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

function ban_user_from_user_ID($user_ID): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "UPDATE Users SET banned = true WHERE id = '{$user_ID}' ";

    mysqli_query($con, $query);

    mysqli_close($con);
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

function update_user_bio_from_user_ID($user_ID, $bio): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // USER BEVERAGES
    $query = "UPDATE Users set description = {$bio} WHERE id = '{$user_ID}'";
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

function get_age_from_user_ID(string $user_ID): string
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
        $birthDate = explode("-", $result->fetch_array()[0]);
        return (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
            ? ((date("Y") - $birthDate[0]) - 1)
            : (date("Y") - $birthDate[0]));
    }
    return "";
}


function set_id_email_pw_fname_lname_dob_jd($db_host, $db_username, $db_password, $db_database, $id): void
{

    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

    if ($mysqli->connect_errno) {
        die("Connection Error: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->stmt_init();

    $sql = "INSERT INTO Users (id, email, hashedpassword, firstname, lastname, dateofbirth, datejoined)
VALUES (?,?,?,?,?,?,?)";

    if (!$stmt->prepare($sql)) {
        die("SQL ERROR : " . $mysqli->error);
    }

    $stmt->bind_param("sssssss",
        $id,
        $_POST["user_email"],
        $hashed_user_password,
        $_POST["user_first_name"],
        $_POST["user_second_name"],
        $date,
        $time_now,
    );

    try {
        $stmt->execute();
    } catch (Exception $e) {
        $errors['errors'][] = "Email is linked to existing account \r";
        echo json_encode($errors);
        mysqli_close($mysqli);
        exit();
    }
    mysqli_close($mysqli);
}

function get_email_pass_login($db_host, $db_username, $db_password, $db_database)
{
    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);


    $query = "SELECT * FROM Users where email = ?";

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if ($con->connect_error) {
        die("Connection Failed: " . $con->connect_error);
    }
    $st = $con->prepare($query);

    if ((!$st)) {
        die("Error occurred in preparing statement: " . $con->error);
    }

    $st->bind_param("s", $email);
    $st->execute();

    $res = $st->get_result();

    if (!$res) {
        die("Error occurred in getting result: " . $con->error);
    }
    if ($res->num_rows === 0) {
        $alerts = ("Invalid Login");
        exit();
    }
    $row = $res->fetch_assoc();
    mysqli_close($mysqli);
    return $row;
}

?>