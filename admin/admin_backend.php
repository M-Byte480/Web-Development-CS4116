<?php
global $host, $user, $pass, $db;
require_once("./admin_functions.php"); // This validates you are an admin and logged in
require_once("../database/repositories/users.php");
require_once("../secrets.settings.php");



// Get user id from cookies
$id = $_COOKIE["user_id"];

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

global $return_values;
switch ($_GET['request_type']){
    case 'getAllUsers':
        $return_values = getAllUsers();
}

mysqli_close($con);

echo $return_values;
?>