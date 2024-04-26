<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/images.php');
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
    require_once(__DIR__ . "/../imports.php");
    ?>
    <link rel="stylesheet" href="styles.css">

    <title>Discovery</title>

</head>
<?php
require_once(__DIR__ . "/../nav_bar/index.php");
?>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            There is no more suggestions for now!
        </div>
        <div class="col-12">
            Try changing your interests or wait while other bev-enjoyers are signing up!
        </div>
        <div class="col-12">
            OR maybe try some other drink
        </div>
    </div>
</div>
</body>
</html>