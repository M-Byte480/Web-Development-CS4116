<?php
require_once('../../validators.php');

function getUserById($id) // SQL Array
{
    global $con;
    $query = "SELECT * FROM user WHERE id = '{$id}'";
    return mysqli_query($con, $query);
}

function getAllUsers() // SQL Array
{
    global $con;
    $query = "SELECT * FROM user";
    return mysqli_query($con, $query);
}

function getUserByCredentials($email, $hashed_password) // SQL Array
{
    global $con;
    $query = "SELECT * FROM user";

    return mysqli_query($con, $query);
}


?>