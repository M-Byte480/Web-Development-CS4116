<?php
global $host, $user, $pass, $db;
require_once("../database/users/users.php");
require_once("../secrets.settings.php");

$con = mysqli_connect($host, $user, $pass, $db);


if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
function validateAdmin($id)
{

}

switch ($_GET['request_type']){
    case 'getAllUsers':
        require_once ('./admin_queryUsers.php');

}

mysqli_close($con);
?>