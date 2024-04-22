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
        connections.id AS connectionId,
        users.id AS userId,
        firstname,
        lastname,
        pfp
    FROM
        Connections
    JOIN Users ON connections.userId2 = users.id
    JOIN profilepictures ON connections.userId2 = profilepictures.userId
    WHERE
        userId1 = '{$userId}'
) a
UNION (
    SELECT
        connections.id AS connectionId,
        users.id AS userId,
        firstname,
        lastname,
        pfp
    FROM
        Connections
    JOIN Users ON connections.userId1 = users.id
    JOIN profilepictures ON connections.userId1 = profilepictures.userId
    WHERE
        userId2 = '{$userId}'
)";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>