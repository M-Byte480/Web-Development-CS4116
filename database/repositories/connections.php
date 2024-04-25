<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_connections_from_userId($userId): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT
    *
FROM
    (
    SELECT
        Connections.id AS connectionId,
        Users.id AS userId,
        firstname,
        lastname,
        pfp
    FROM
        Connections
    LEFT JOIN Users ON Connections.userId2 = Users.id
    LEFT JOIN ProfilePictures ON Connections.userId2 = ProfilePictures.userId
    WHERE
        userId1 = '{$userId}'
) a
UNION (
    SELECT
        Connections.id AS connectionId,
        Users.id AS userId,
        firstname,
        lastname,
        pfp
    FROM
        Connections
    LEFT JOIN Users ON Connections.userId1 = Users.id
    LEFT JOIN ProfilePictures ON Connections.userId1 = ProfilePictures.userId
    WHERE
        userId2 = '{$userId}'
)";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result->fetch_all(MYSQLI_ASSOC);
}


function delete_connection_from_user_ids($userid1, $userid2): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "DELETE FROM Connections WHERE userId1 = '{$userid1}' AND userId2 = '{$userid2}' OR userId1 = '{$userid2}' AND userId2 = '{$userid1}'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function create_connection($user_id, $affected_user): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "INSERT INTO Connections (userId1, userId2) VALUES ('{$user_id}', '{$affected_user}')";
    mysqli_query($con, $query);
    mysqli_close($con);
}

?>