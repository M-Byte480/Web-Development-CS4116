<?php
function validate_admin($id)
{
    if (!validate_user_id($id)) {
        echo 'Invalid ID';
        exit();
    }

    $retrieved_user = getUserById($id);

    if (array_key_exists('admin', $retrieved_user)) {
        if ($retrieved_user['admin'] === 1) {
            return true;
        }
    }
    return false;
}

// Validation

if (!isset($_COOKIE['email']) || !isset($_COOKIE['password'])) {
    header("Location: ../login/index.php");
    exit();
}

$user = getUserById($_COOKIE['user_id']);

if (validate_admin($user) != 1) {
    echo 'Unauthorised';
    exit();
}


?>