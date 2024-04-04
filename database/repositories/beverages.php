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


    $query = "SELECT * FROM beverages ";

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

    $query = "SELECT name FROM beverages INNER JOIN userbeverages ON beverages.id = userbeverages.beverageId WHERE userbeverages.userId = '{$user_ID}'";
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

    $query = "UPDATE userbeverages SET beverageId = '{$bev_id}' WHERE userbeverages.userId = '{$user_ID}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

?>