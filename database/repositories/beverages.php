<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_beverages(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Beverages ";

    $result = mysqli_query($con, $query);

    mysqli_close($con);


    return $result->fetch_all();
}

function get_users_beverage_from_user_ID(string $user_ID): string|null
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

    $query = "SELECT name FROM Beverages INNER JOIN UserBeverages ON Beverages.id = UserBeverages.beverageId WHERE UserBeverages.userId = '{$user_ID}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return null;
}

function update_users_beverage_from_user_ID(string $user_ID, int $bev_id): void
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

    $query = "SELECT * FROM UserBeverages WHERE userid = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
        $query = "UPDATE UserBeverages SET beverageId = {$bev_id} WHERE userId = '{$user_ID}'";
    } else {
        $query = "INSERT INTO UserBeverages (userId, beverageId) VALUES ('{$user_ID}', {$bev_id})";
    }
    mysqli_query($con, $query);

    mysqli_close($con);
}

?>