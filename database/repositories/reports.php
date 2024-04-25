<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

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

function check_if_report_exists($user_id, $affected_user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $stmt = $con->prepare("SELECT * FROM Reports WHERE reporterId = ? AND reportedId = ?");
    $stmt->bind_param("ss", $user_id, $affected_user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    mysqli_close($con);
    return $data;
}