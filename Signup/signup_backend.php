<?php

require_once(__DIR__ . '/../validator_functions.php');
//global $host, $user, $db, $pass;
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../secrets.settings.php');
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
} else if (!preg_match("/[a-z]/i", $_POST["user_password"]) || !preg_match("/[0-9]/", $_POST["user_password"])) {
    $errors[] = "Password must contain at least one letter \r";
} else if (!isset($_POST['user_password'])) {
    $errors[] = "Password field is empty \r";
}

if ($_POST["user_password"] !== $_POST["password_confirmation"]) {
    $errors[] = "Passwords must match \r";
}

$radioVal = $_POST["gender"];
$gender = '';
if ($radioVal === "Male") {
    $gender = "Male";
} else if ($radioVal === "Female") {
    $gender = "Female";
} else if ($radioVal === "Other") {
    $gender = "Other";
}

if ($gender === '') {
    $errors[] = "Please specify your gender \r";
}


if (!empty($errors)) {
    echo json_encode(array('errors' => $errors));
    exit();
}

function custom_uuid()
{
    $bytes = random_bytes(16);
    
    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

    // Format the bytes as a UUID
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

$id = custom_uuid();
$hashed_user_password = hash("sha256", ($_POST["user_password"]));
$time_now = date('Y-m-d');
$date = date('Y-m-d', strtotime($_POST["user_dob"]));


$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

if ($mysqli->connect_errno) {
    die("Connection Error: " . $mysqli->connect_error);
}

$stmt = $mysqli->stmt_init();

$sql = "INSERT INTO Users (id, email, hashedpassword, firstname, lastname, dateofbirth, datejoined)
VALUES (?,?,?,?,?,?,?)";

if (!$stmt->prepare($sql)) {
    die("SQL ERROR : " . $mysqli->error);
}

$stmt->bind_param("sssssss",
    $id,
    $_POST["user_email"],
    $hashed_user_password,
    $_POST["user_first_name"],
    $_POST["user_second_name"],
    $date,
    $time_now,
);


if (!($stmt->execute())) {
    if ($mysqli->errno === 1062) {
        die("An account with this email currently exists");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
$stmt = $mysqli->stmt_init();

$sql = "INSERT INTO Profiles (userId,gender)
    VALUES (?,?)";

if (!$stmt->prepare($sql)) {
    die("SQL ERROR : " . $mysqli->error);
}

try {
    $stmt->bind_param("ss",
        $id,
        $gender
    );
    $stmt->execute();
} catch (Exception $e) {
    print_r($e);
    mysqli_close($mysqli);
    exit();
};

mysqli_close($mysqli);
echo json_encode(array('success' => 1));
exit();
?>