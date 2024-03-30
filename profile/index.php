<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user.php');

require_once(__DIR__ . "/../database/repositories/beverages.php");
require_once(__DIR__ . "/../database/repositories/interests.php");
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/profiles.php");

$user_ID = (string)get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];

function display_interests(): void
{
    global $user_ID;
    $interests = get_user_interests_from_user_ID($user_ID);

    if (is_null($interests)) {
        echo("No interests :(");
        return;
    }

    foreach ($interests as $interest) {
        echo("<li>" . $interest[0] . "</li>");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Profile Page</title>

    <style>
        ul {
            list-style-type: none;
            padding-left: 1em
        }

        img.img-fluid {
            object-fit: cover;
            border: 2px black solid;
            height: 200px;
            width: 200px;
        }
    </style>
</head>
<body>
<?php require_once("../nav_bar/index.php"); ?>
<div class="row m-3 p-3 text-center text-sm-start">
    <div class="col-md-4 col-sm-12 p-3 d-flex align-items-center justify-content-center">
        <div>
            <img src="<?= get_user_pfp_from_user_ID($user_ID) ?>" alt="Profile Picture"
                 class="rounded-circle img-fluid">
        </div>
    </div>
    <div class="col-md-8 col-sm-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100">
            <h2>About Me</h2>
            <p>
                <?php echo get_user_description_from_user_ID($user_ID) ?? "No bio :("; ?>
            </p>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100">
            <h2>My Pictures</h2>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100">
            <h2>Go To Drink</h2>
            <ul>
                <li><?= get_users_beverage_from_user_ID($user_ID) ?? "Water (boo)" ?></li>
            </ul>
            <h2>My Interests</h2>
            <ul>
                <?php display_interests() ?>
            </ul>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100">
            <h2>Looking For</h2>
            <ul> <?= get_user_seeking_from_user_ID($user_ID) ?? "Seeking help" ?>
            </ul>
        </div>
    </div>
</div>
</body>
