<?php
global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_user_description_from_user_ID(string $user_ID): string|null // base64
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

    $query = "SELECT description FROM Profiles WHERE userId = '{$user_ID}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return null;
}

function update_user_description_from_user_ID(string $user_ID, string $new_desc): void
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

    $query = "UPDATE Profiles SET description = '{$new_desc}' WHERE userId = '{$user_ID}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function get_user_seeking_from_user_ID(string $user_ID): string|null // base64
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

    $query = "SELECT seeking FROM Profiles WHERE userId = '{$user_ID}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return null;
}

function update_user_seeking_from_user_ID(string $user_ID, string $new_seeking): void
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

    $query = "UPDATE Profiles SET seeking = '{$new_seeking}' WHERE userId = '{$user_ID}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function set_id_gender($id, $gender): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

    $stmt = $mysqli->stmt_init();

    $sql = "INSERT INTO Profiles (userId,gender)
    VALUES (?,?)";

    if (!$stmt->prepare($sql)) {
        die("SQL ERROR : " . $mysqli->error);
    }

    try {
        $stmt->bind_param("ss",
            $id,
            $gender
        );
        $stmt->execute();
    } catch (Exception $e) {
        mysqli_close($mysqli);
        exit();
    }

    mysqli_close($mysqli);
}

function get_user_profile($user_id)
{

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Profiles WHERE userid = '{$user_id}'";
    $result = mysqli_query($con, $query);

    return $result;
}

?>