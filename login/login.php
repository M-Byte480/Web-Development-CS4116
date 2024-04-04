<?php

session_start();

global $db_host, $db_username, $db_password, $db_database;

require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . '/../secrets.settings.php');

print_r($_POST);

if (!(isset($_POST['email']) && isset($_POST['password']))) {
    echo "No email or password set";
    exit();
}

$email = $_POST['email'];

$password = $_POST['password'];

if (empty($email) || empty($password)) {
    echo "Please fill in all text fields";
    var_dump(function_exists('mysqli_connect'));
    exit();
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

if (!isset($row['password'])) {
    die("Error: password is not contained in fetched row");
}

if (password_verify($password, $row['password'])) {

    $_SESSION['user id'] = $row['id'];
    echo "Login Successful";
} else {
    echo "Invalid Login";
}


?>



