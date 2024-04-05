<?php

require_once (__DIR__ . '/../validators.php');

$host = 'localhost';
$dbname = 'pub_club';
$username = 'root';
$password = '';

$gender = '';
;

$errors = [];


if (!isset($_POST['user_email'])) {
    $errors[] = "Email is empty \r";
} elseif (!validate_email($_POST['user_email'])) {
    $errors[] = "Invalid email format \r";
}

if (!isset($_POST['user_first_name'])) {
    $errors[] = "First name is empty \r";
}

if (!isset($_POST['user_second_name'])) {
    $errors[] = "Surname is empty \r";
}

if (strlen($_POST["user_password"]) < 8) {
    $errors[] = "Password must be at least 8 characters \r";
} else if ( ! preg_match("/[a-z]/i", $_POST["user_password"]) || ! preg_match("/[0-9]/", $_POST["user_password"])) {
    $errors[] = "Password must contain at least one letter \r";
} else if(!isset($_POST['user_password'])){
    $errors[] = "Password field is empty \r";
}

if ($_POST["user_password"] !== $_POST["password_confirmation"]) {
    $errors[] =  "Passwords must match \r";
}

$radioVal = $_POST["gender"];

if($radioVal === "Male")
{
    $gender = "Male";
}
else if ($radioVal === "Female")
{
    $gender = "Female";
}
else if ($radioVal === "Other")
{
    $gender = "Other";
}

if($gender === ''){
    $errors[] = "Please specify your gender \r";
}


if(!empty($errors)){
    echo json_encode(array('errors' => $errors));
    exit();
}

$id = uniqid();
$hashed_user_password = password_hash($_POST["user_password"], PASSWORD_DEFAULT);
$time_now = date('Y-m-d');
$date = date('Y-m-d', strtotime($_POST["user_dob"]));

$mysqli = new mysqli($host,$username,$password,$dbname);

if($mysqli->connect_errno){
    die("Connection Error: " . $mysqli->connect_error);
}

$stmt = $mysqli->stmt_init();

$sql = "INSERT INTO users (id, email, hashedpassword, firstname, lastname, dateofbirth, datejoined, gender)
VALUES (?,?,?,?,?,?,?,?)";

if(!$stmt->prepare($sql)){
    die("SQL ERROR : " . $mysqli->error);
}

$stmt->bind_param("ssssssss",
                $id,
                $_POST["user_email"],
                $hashed_user_password,
                $_POST["user_first_name"],
                $_POST["user_second_name"],
                $date,
                $time_now,
                $gender
              );


if($stmt->execute()) {
    mysqli_close($mysqli);
    echo json_encode(array('success' => 1));
    exit();
    } else {
        if ($mysqli->errno === 1062) {
            die("An account with this email currently exists");
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
}
?>