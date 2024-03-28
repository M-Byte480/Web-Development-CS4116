
<?php

require_once("../database/repositories/users.php");
// Validate is user logged in
require_once(__DIR__ . '/../validate_user.php');

require_once(__DIR__ . "/../database/repositories/beverages.php");
require_once(__DIR__ . "/../database/repositories/interests.php");
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
require_once(__DIR__ . "/../database/repositories/users.php");

$userID = get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Profile Page</title>

    <style>
        img {
            width: 100%;
            border: 1em black;
        }
        ul {
            list-style-type: none;
            padding-left: 1em
        }
    </style>
</head>
<body>
    <?php require_once("../NavBar/index.php"); ?>
    <div class="row p-3 m-3">
        <div class="col-4">
            <div>
                <img src="../resources/milanPFP.png" alt="Profile Picture">
            </div>
        </div>
        <div class="col-8 bg-secondary rounded-3 p-3">
            <h2>About Me</h2>
            <p>
<!--                --><?php //= get['id'] ?>
            </p>
        </div>
    </div>
    <div class="row p-3 m-3">
        <div class="col bg-secondary rounded-3 p-3 m-2">
            <h2>My Pictures</h2>
        </div>
        <div class="col bg-secondary rounded-3 p-3 m-2">
            <h2>Go To Drink</h2>
            <ul>
                <li>Long Island Iced Tea</li>
            </ul>
            <h2>My Interests</h2>
            <ul>
                <li>Casual Drinking</li>
                <li>Partying</li>
                <li>Coding</li>
                <li>Guinness</li>
            </ul>
        </div>
        <div class="col bg-secondary rounded-3 p-3 m-2">
            <h2>Looking For</h2>
            <ul>
                <li><p>Female</p></li>
                <li><p>Competitive Driver</p></li>
                <li><p>Non-Drinker</p></li>
            </ul>
        </div>
    </div>
</body>
