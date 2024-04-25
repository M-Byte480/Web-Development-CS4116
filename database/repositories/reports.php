<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');


function add_new_report($reporter_id, $reported_user_id, $msg): bool
{
    require_once(__DIR__ . '/users.php');
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $success = true;
    try {

        $query = "INSERT INTO Reports (reporterId, reportedId, reason) VALUES ('{$reporter_id}', '{$reported_user_id}', '{$msg}' );";
        mysqli_query($con, $query);
        mysqli_close($con);

    } catch (Exception $e) {
        $success = false;
    }

    if ($success) {
        increment_report_count($reporter_id);
    }

    return $success;
}

function get_user_report_history_by_id($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT * FROM Reports WHERE reportedId = '{$user_id}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_assoc();
}