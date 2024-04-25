<?php

require_once(__DIR__ . '/ban_functions.php');

$ban = get_recent_ban_of_this_user();

if ($ban == null) { // if this user shouldn't been banned
    $user = get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc();
    change_user_ban_state_by_user_id($user['id'], false);
    header('Location: ../profile');
    exit();
}

// Check if Ban is permanent
if ($ban['permanent'] == 1) {
    header('Location: ./banned.php');
    exit();
}


// Check if Ban has expired
if (is_temporary_ban_expired($ban)) {
    // Update state
    require_once(__DIR__ . '/../database/repositories/users.php');
    change_user_ban_state_by_user_id($ban['userId'], false);

    // Goto home
    header('Location: ../profile');
    exit();
}
header('Location: ./banned.php');
exit();