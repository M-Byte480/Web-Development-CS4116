<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_chatlogs_from_connectionId($connectionId): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT userSent, time, content FROM ChatLogs WHERE connectionId='{$connectionId}' ORDER BY time ASC";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_chatlog($connectionId, $userSent, $content): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "INSERT INTO ChatLogs(userSent, connectionId, content) VALUES ('{$userSent}', '{$connectionId}', '{$content}')";
    mysqli_query($con, $query);
    mysqli_close($con);
}

?>