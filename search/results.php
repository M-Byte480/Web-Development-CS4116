<?php
// Validate is user logged in
require_once(__DIR__ . '/../validators.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require_once(__DIR__ . '/../css_binding.php'); ?>

    <title>PubClub Admin</title>
</head>
<body>

<?php require_once(__DIR__ . '/../NavBar/index.php'); ?>

<?php

$searched_users = array(1, 2, 3, 4, 5, 6, 89, 1, 1, 1, 1, 1, 1, 1, 1, 11, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

$user_count = sizeof($searched_users);

$iterations = (int)($user_count / 4);
$modulo = $user_count % 4;


?>

<div class="container">
    <div class="row">
        <?php
        require_once(__DIR__ . '/profile_card.php');
        for ($i = 0; $i < $iterations; $i++) {
            ?>
            <div class="col-6 col-md-3">
                User 1
            </div>
            <div class="col-6 col-md-3">
                User 2
            </div>
            <div class="col-6 col-md-3">
                User
            </div>
            <div class="col-6 col-md-3">
                User 4
            </div>
            <?php
        }

        for ($i = 0; $i < $modulo; $i++) {
            ?>
            <div class="col-6 col-md-3">
                User 1
            </div>
            <?php
        }
        ?>

    </div>
</div>


</body>
</html>
