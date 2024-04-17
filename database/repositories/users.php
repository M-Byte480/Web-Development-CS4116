<?php
require_once(__DIR__ . '/../../validator_functions.php');

global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');


function get_user_from_user_ID($user_ID): array
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


    $query = "SELECT * FROM Users WHERE id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_assoc();
}

function get_all_users(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Users";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_all_user_ids(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT id FROM users";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return array_column($result->fetch_all(), 0);
}

function get_user_by_credentials($email, $hashed_password): mysqli_result
{
    global $db_host, $db_username, $db_password, $db_database;
    if (!validate_email($email)) {
        echo 'invalid email';
        exit();
    }
    if (!validate_hashed_password($hashed_password)) {
        echo 'invalid password';
        exit();
    }

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT * FROM Users WHERE email = '{$email}' AND hashedPassword = '{$hashed_password}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result;
}


function delete_user_from_user_ID($user_ID): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // USER BEVERAGES
    $query = "DELETE FROM Users WHERE id = '{$user_ID}'";
    mysqli_query($con, $query);


    mysqli_close($con);
}


function get_first_name_from_user_ID(string $user_ID): string
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT firstName FROM Users where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return "";
}

function get_last_name_from_user_ID(string $user_ID): string
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT lastName FROM users where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    if ($result->num_rows > 0)
        return $result->fetch_array()[0];
    return "";
}


function get_DOB_from_user_ID(string $user_ID): string
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT dateOfBirth FROM Users where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    if ($result->num_rows > 0) {
        return $result->fetch_array()[0];
    }
    return "";
}

function get_age_from_user_ID(string $user_ID): string
{
    return get_age_from_DOB(get_DOB_from_user_ID($user_ID));
}

function update_first_name_from_user_ID(string $user_ID, string $new_name): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "UPDATE users SET firstName = '{$new_name}' where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
}

function update_last_name_from_user_ID(string $user_ID, string $new_name): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "UPDATE users SET lastName = '{$new_name}' where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
}

function update_DOB_from_user_ID(string $user_ID, string $new_DOB): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "UPDATE users SET dateOfBirth = '{$new_DOB}' where id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
}

function get_user_by_id($id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT * FROM Users where id = '{$id}'";
    $result = mysqli_query($con, $query);
    mysqli_close($con);
    return $result->fetch_all(MYSQLI_ASSOC)[0];
}

function get_user_id_by_email($email)
{
    $id = null;

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // Query to fetch the user's ID based on email
    $query = "SELECT id FROM Users WHERE email = '{$email}'";
    $result = mysqli_query($con, $query);
    $con->close();

    return $result->fetch_assoc()['id'];
}

function change_user_ban_state_by_user_id($user_id, $state): bool
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $success = true;

    try {
        // Get true and false for
        $mysqli_bool = $state ? 1 : 0;

        $query = "UPDATE Users set banned = {$mysqli_bool}  where id = '{$user_id}'";
        mysqli_query($con, $query);
    } catch (Exception $e) {
        print_r($e);
        $success = false;
    } finally {
        mysqli_close($con);
    }

    return $success;
}

function get_age_from_DOB($DOB): string
{
    $birthDate = explode("-", $DOB);
    if ($birthDate) {
        return (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
            ? ((date("Y") - $birthDate[0]) - 1)
            : (date("Y") - $birthDate[0]));
    }
    return "";
}

?>