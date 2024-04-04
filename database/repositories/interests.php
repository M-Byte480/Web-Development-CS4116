<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_interests(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Interests";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_all();
}

function get_user_interests_from_user_ID(string $user_ID): array|null // base64
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

    $query = "SELECT name FROM Interests INNER JOIN UserInterests ON interests.id = UserInterests.interestId WHERE UserInterests.userId ='{$user_ID}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);

    if ($result->num_rows > 0) {
        return array_column($result->fetch_all(), 0);
    }
    return null;
}

function update_users_interests_from_user_ID(string $user_ID, array $interest_ids): void
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

    $query = "DELETE FROM userinterests WHERE userId = '{$user_ID}'";
    mysqli_query($con, $query);
    foreach ($interest_ids as $interest_id) {
        $query = "INSERT INTO userinterests (userId, interestId) VALUES ('{$user_ID}', '{$interest_id}')";
        mysqli_query($con, $query);
    }
    mysqli_close($con);
}

?>