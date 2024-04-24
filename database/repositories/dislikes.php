<?php

global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_disliked_user_by_user_id($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $disliked_users = array();
    $query = "SELECT dislikedUser FROM Dislikes WHERE userId = '{$user_id}'";
    $result = mysqli_query($con, $query);

    while ($disliked_user = $result->fetch_assoc()) {
        $disliked_users[] = $disliked_user;
    }

    $con->close();

    return $disliked_users;
}

function add_dislike_by_user_ids($user_id1, $user_id2)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "INSERT INTO Dislikes (userId, dislikedUser) VALUES ('{$user_id1}', '{$user_id2}')";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function create_dislike_record($affected_id, $logged_in_user_id): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "INSERT INTO Dislikes (userId, dislikedUser, time)
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

?>