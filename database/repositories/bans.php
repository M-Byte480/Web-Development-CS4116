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

function get_most_recent_ban($user_id): null|array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT ban.* 
                FROM Bans ban 
                INNER JOIN (
                    SELECT MAX(time) AS max_time 
                    FROM Bans
                    WHERE userId = '{$user_id}' 
                    GROUP BY userId) as recent_ban
                WHERE ban.userId = '{$user_id}'  AND ban.time = recent_ban.max_time;";


    $result = mysqli_query($con, $query);
    mysqli_close($con);
    $output = '';
    if (mysqli_num_rows($result) == 0) {
        $output = null;
    } else {
        $output = $result->fetch_assoc();
    }

    return $output;
}

function get_user_ban_history_by_id($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT * FROM Bans WHERE userId = '{$user_id}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result;
}