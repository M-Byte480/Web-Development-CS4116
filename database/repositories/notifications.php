<?php
global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function create_notifcation_for_user($affected_user, $msg)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "INSERT INTO Notifications (userId, reason) VALUES ('$affected_user', '$msg')";

    mysqli_query($con, $query);
    mysqli_close($con);
}

function get_all_notifcations($affected_user)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "SELECT * FROM Notifications WHERE userId = '$affected_user'";

    $result = mysqli_query($con, $query);
    mysqli_close($con);

    return $result;

}

function check_for_nofication($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "SELECT * FROM Notifications WHERE userId = '$user_id'";

    $result = mysqli_query($con, $query);
    mysqli_close($con);

    return $result->fetch_assoc();
}

function remove_all_notifications($userId): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "DELETE FROM Notifications WHERE userId = '$userId'";

    mysqli_query($con, $query);
    mysqli_close($con);

}

?>