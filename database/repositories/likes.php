<?php

global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_liked_user_by_user_id($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $liked_users = array();
    $query = "SELECT likedUser FROM Likes WHERE userId = '{$user_id}'";
    $result = mysqli_query($con, $query);

    while ($liked_user = $result->fetch_assoc()) {
        $liked_users[] = $liked_user;
    }

    $con->close();

    return $liked_users;
}

?>