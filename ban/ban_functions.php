<?php

function get_recent_ban_of_this_user(): false|array|null
{
    require_once(__DIR__ . '/../database/repositories/users.php');
    require_once(__DIR__ . '/../database/repositories/bans.php');
    $user_id = get_user_id_by_email($_COOKIE['email']);
    return get_most_recent_ban($user_id);
}


function is_temporary_ban_expired($ban): bool
{
    $today = new DateTime('now');
    $endDate = new DateTime($ban['endDate']);

    $expired = false;
    if ($endDate < $today) {
        $expired = true;
    }

    return $expired;
}

function is_user_banned($ban): bool
{
    if ($ban['permanent']) {
        return true;
    }

    if ($ban['endDate'] !== null) {
        return !is_temporary_ban_expired($ban);
    }

    return false;
}

function display_ban_days_duration($ban)
{
    $today = new DateTime('now');
    $endDate = new DateTime($ban['endDate']);

    if ($ban['permanent']) {
        echo "YOU ARE PERMA BANNED";
        exit();
    }

    $diff = date_diff($today, $endDate);
    echo $diff->format('You are banned for %a days');
}
