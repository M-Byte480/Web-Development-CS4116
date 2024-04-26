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
    <?php
    require_once(__DIR__ . "/../imports.php");
    ?>
    <title>No Matches</title>
</head>
<body>
<?php
require_once(__DIR__ . '/../nav_bar/index.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">

            <h1 class="display-1 ">No Matches Found</h1>
            <img src="../resources/no_match/drinking-alone.jpg" alt="sad man" class="img-fluid col-10">
            <p class="display-5 ">There are no matches available for you at this time. Might I suggest updating
                your
                profile?</p>
            <a href="/profile/" class="btn btn-primary ">Update Profile</a>
        </div>
    </div>
</body>