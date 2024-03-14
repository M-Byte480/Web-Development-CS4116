<?php
function validate_admin($id)
{
    if (!validate_user_id($id)) {
        echo 'Invalid ID';
        exit();
    }

    $retrieved_user = getUserById($id);

    return $retrieved_user['admin'];
}


?>