<?php
function get_user_name($user)
{
    return $user['firstName'] . ' ' . $user['lastName'];
}

/**
 * @throws Exception
 */
function get_user_age($user)
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function ban_user()
{
    echo 'user banned';
}

function set_ban_state($id, $state)
{

}

?>