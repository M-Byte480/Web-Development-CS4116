<?php
function get_user_name($user)
{
    return $user['firstName'] . ' ' . $user['lastName'];
}

/**
 * @throws Exception
 */
function get_user_age($user): int
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function ban_user($user_id): void
{
    echo 'user banned';
}

function set_ban_state($id, $state)
{

}

?>