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

function delete_like_by_user_ids($user_id1, $user_id2)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "DELETE FROM Likes WHERE userId = '{$user_id1}' AND likedUser = '{$user_id2}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function add_like_by_user_ids($logged_in_user_id, $affected_id): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "INSERT INTO Likes (userId, likedUser, time)
              VALUES (?, ?, NOW())";

    $stmt = mysqli_prepare($con, $query);


    if (!$stmt) {
        die('Error in preparing statement: ' . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $logged_in_user_id, $affected_id);

    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        die('Error in executing statement: ' . mysqli_error($con));
    }

    mysqli_stmt_close($stmt);

    mysqli_close($con);
}

function does_like_exist($user_id, $affected_user)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "SELECT likedUser FROM Likes WHERE userId = '{$user_id}' and likedUser = '{$affected_user}'";
    $result = mysqli_query($con, $query);
    //like exists when mysqli_num_rows($result) >1  TRUE
    //like missing when mysqli_num_rows($result) = 0 FALSE
    return mysqli_num_rows($result) == 1;

}

function check_if_a_new_connection_is_formed($user_id, $affected_user)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "SELECT * FROM Likes WHERE userId = '{$affected_user}' and likedUser = '{$user_id}'";
    $result = mysqli_query($con, $query);

    return mysqli_num_rows($result) == 1;
}

?>