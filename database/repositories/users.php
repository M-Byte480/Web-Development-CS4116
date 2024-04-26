<?php
require_once(__DIR__ . '/../../validator_functions.php');

global $db_host, $db_username, $db_password, $db_database, $db_some_secret, $secret_encryption_method, $secret_encryption_key;
require_once(__DIR__ . '/../../secrets.settings.php');


function get_user_from_user_ID($user_ID)
{
    if (!validate_user_id($user_ID)) {
        return false;
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


    $query = "SELECT id FROM Users";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return array_column($result->fetch_all(), 0);
}

function get_user_by_credentials($email, $hashed_password): mysqli_result
{
    global $db_host, $db_username, $db_password, $db_database;
    require_once(__DIR__ . '/../../encryption/encryption.php');
    $email = decrypt($email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

function get_user_profile_from_credentials($email, $hashed_password)
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    require_once(__DIR__ . '/../../encryption/encryption.php');
    $email = decrypt($email);

    $query = "SELECT *, B.name as favourite_beverage, U.id as id
            FROM Users as U
                LEFT JOIN Profiles as P ON U.id = P.userId
                LEFT JOIN UserBeverages as UB ON U.id = UB.userId
                LEFT JOIN Beverages as B ON UB.beverageId = B.id
            WHERE email = '{$email}' AND hashedPassword = '{$hashed_password}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_assoc();
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

    $query = "SELECT lastName FROM Users where id = '{$user_ID}'";
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
    require_once(__DIR__ . '/../../encryption/encryption.php');

    $email = decrypt($email);

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


function add_user_to_database($id, $email, $first_name, $second_name, $password, $date_of_birth): void
{
    global $db_host, $db_username, $db_password, $db_database;


    $hashed_user_password = hash("sha256", $password);
    $time_now = date('Y-m-d');
    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

    if ($mysqli->connect_errno) {
        die("Connection Error: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->stmt_init();

    $sql = "INSERT INTO Users (id, email, hashedpassword, firstname, lastname, dateofbirth, datejoined, banned, admin, reportCount)
VALUES (?,?,?,?,?,?,?,0,0,0)";

    if (!$stmt->prepare($sql)) {
        die("SQL ERROR : " . $mysqli->error);
    }

    $stmt->bind_param("sssssss",
        $id,
        $email,
        $hashed_user_password,
        $first_name,
        $second_name,
        $date_of_birth,
        $time_now,
    );

    $stmt->execute();

    mysqli_close($mysqli);
}

function get_user_from_email($email)
{

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Users where email = '{$email}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);


    return $result->fetch_assoc();
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

function is_email_taken($email)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Users where email = '{$email}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);


    return 0 != mysqli_num_rows($result);
}

//function increment_report_count($userId): void
//{
//    global $db_host, $db_username, $db_password, $db_database;
//    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
//    if (!$con) {
//        die('Could not connect: ' . mysqli_error($con));
//    }
//
//    $query = "SELECT reportCount FROM Users where id = '{$userId}'";
//    $result = mysqli_query($con, $query)->fetch_assoc()["reportCount"] + 1;
//
//    $query = "UPDATE Users SET reportCount = {$result} where id = '{$userId}'";
//    mysqli_query($con, $query);
//
//    mysqli_close($con);
//}
function increment_report_count($userId): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT reportCount FROM Users where id = '{$userId}'";
    $result = mysqli_query($con, $query)->fetch_assoc()["reportCount"] + 1;

    $query = "UPDATE Users SET reportCount = {$result} where id = '{$userId}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}


?>