<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $db_host, $db_username, $db_password, $db_database;

require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . '/../secrets.settings.php');

print_r($_POST);

if (!(isset($_POST['email']) && isset($_POST['password']))) {
    echo "No email or password set";
    exit();
}

$email = trim($_POST['email']);
echo "Email being sent: " . $email . "\n";

$password = $_POST['password'];
echo "Password being sent: " . $password . "\n";

if (empty($email) || empty($password)) {
    echo "Please fill in all text fields";
    exit();
}

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

if ($mysqli->connect_errno) {
    die("Error connecting to sql: " . $mysqli->connect_errno);
}

$query = "SELECT * FROM users where email = ?";

$con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}
$st = $con->prepare($query);

if ((!$st)) {
    die("Error occurred in preparing statement: " . $con->error);
}

$st->bind_param("s", $email);
$st->execute();

$res = $st->get_result();

if (!$res) {
    die("Error occurred in getting result: " . $con->error);
}

if ($res->num_rows === 0) {
    echo "Invalid Login";
    exit();
}

$row = $res->fetch_assoc();

if (!isset($row['hashedPassword'])) {
    die("Error: password is not contained in fetched row");
}


if (($row['hashedPassword'] === hash("sha256", $password))) {

    $_SESSION['user id'] = $row['id'];
    $_SESSION['name'] = $row['firstname'];
    setcookie('hashed_password', $row['hashedPassword'], time() + 60 * 60 * 24 * 7, '/');
    setcookie('email', $row['email'], time() + 60 * 60 * 24 * 7, '/');
    echo "Login Successful";
    header("Location: ./../profile/index.php");
} else {
    echo "Invalid Login";
}
exit();

?>



