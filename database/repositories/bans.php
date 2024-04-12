<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');
require_once(__DIR__ . '/users.php');
function enter_new_ban($banned_by_email, $unban_date, $user_id, $is_permanent, $reason): bool
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $banned_by = get_user_id_by_email($banned_by_email);
    $now = date("Y-m-d H:i:s");

    if ($is_permanent) {

        // Perma ban
        $query = "INSERT INTO Bans (userId, bannedBy, time, reason, permanent) VALUES ('{$user_id}', '{$banned_by}', '{$now}', '{$reason}', 1)";

    } else {

        // Temp
        $query = "INSERT INTO Bans (userId, bannedBy, time, reason, permanent, endDate) VALUES ('{$user_id}', '{$banned_by}', '{$now}', '{$reason}', 0, '{$unban_date}')";

    }

    $success = true;
    try {
        mysqli_query($con, $query);
    } catch (Exception $e) {
        echo $e;
        $success = false;
    } finally {
        mysqli_close($con);
    }
    return $success;
}