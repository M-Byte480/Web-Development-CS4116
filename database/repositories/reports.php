<?php
global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_user_report_from_user_ID(string $user_ID): string|null // base64
{
    if (!validate_user_id($user_ID)) {
        echo 'invalid ID';
        exit();
    }

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT report FROM Reports WHERE userId = '{$user_ID}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return null;
}

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
