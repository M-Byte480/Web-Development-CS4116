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

function display_ban_days_duration($ban)
{
    $today = new DateTime('now');
    $endDate = new DateTime($ban['endDate']);

    if ($ban['permanent']) {
        echo "YOU ARE PERMA BANNED";
        exit();
    }

    $diff = date_diff($today, $endDate);
    echo $diff->format('You are banned for: %R%a days');

}


function display_ban_time_duration($ban): void
{
    $time = new DateTime('now');
    $endtime = new DateTime($ban['endDate']);

    if ($ban['permanent']) {
        exit();
    }

    $diff = $time->diff($endtime);
    $interval = $diff->format('%h:%i:%s');

    $output = list($hour, $minute, $second) = explode(':', $interval);
}
