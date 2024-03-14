<?php
global $db_host, $db_username, $db_password, $db_database;
require_once("./admin_functions.php"); // This validates you are an admin and logged in
include_once(__DIR__ . "/../database/repositories/users.php");
require_once("../secrets.settings.php");


// Get user id from cookies
$id = $_COOKIE["user_id"];

$con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

global $return_values;


if (isset($_GET['request_type'])) {
    switch ($_GET['request_type']) {
        case 'getAllUsers':
            $return_values = getAllUsers();
    }
}
mysqli_close($con);

echo $return_values;
?>