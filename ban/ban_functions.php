<?php

function get_recent_ban_of_this_user()
{
    require_once (__DIR__ . '/../database/repositories/users.php');
    require_once(__DIR__ . '/../database/repositories/bans.php');
    $user_id = get_user_id_by_email($_COOKIE['email']);
    return get_most_recent_ban($user_id);
}

function calculate_expiration($ban_expiration)
{

}

function is_user_permanently_banned()
{
    
}

function is_temporary_ban_expired($ban)
{
    $today = new DateTime('now');
    $endDate = new DateTime($ban['endDate']);

    $expired = false;
    if($endDate < $today){
        $expired = true;
    }

    return $expired;
}