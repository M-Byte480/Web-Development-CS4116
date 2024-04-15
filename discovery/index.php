<?php
// Validate is user logged in
require_once(__DIR__ . '/../validators.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

require_once(__DIR__ . "/../database/repositories/profilePictures.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
    require_once(__DIR__ . "/../css_binding.php");
    ?>
    <link rel="stylesheet" href="styles.css">

    <title>Discovery</title>

</head>
<script>
    function dislikeUser(userId) {
        console.log(userId);
    }

    function likeUser(userId) {
        console.log(userId);
    }
</script>
<body>
<?php require_once(__DIR__ . '/../NavBar/index.php') ?>

<?php

require_once(__DIR__ . '/discovery_functions.php');
require_once(__DIR__ . '/../database/repositories/interests.php');
require_once(__DIR__ . '/../database/repositories/profile.php');
$user = get_user_from_cookies()->fetch_assoc(); // Creates assoc array so we use [] accessors

// todo: use this are a reference to get potential matches
$this_user_profile = get_user_profile($user['id']);

// Todo: setup cookies to store array of ids alongside with the counter of which user we are on.
// Todo: this helps us track stuff about our user without the need to query the DB constantly
$potential_matches_ids = get_potential_matching_profiles($user['id']);

// todo: add do while to check if suggested user has a profile filled out
//do{
//
//}while();

$suggested_user_profile = get_user_profile($potential_matches_ids[0]);
print_r($suggested_user_profile);

if (sizeof($potential_matches_ids) == 0) {
    echo 'You beat the game';
    exit();
}
function bio_card($user_profile)
{
    ?>
    <div class="bio card m-2 bg-light">
        <div class="card-body ">
            <h5 class="card-body">About Milan</h5>
            <p class="card-text text-center">
                You are the gin to my tonic
            </p>
        </div>
    </div>
    <?php
}

function interest_card($user_profile)
{
    ?>
    <div class="interests card m-2 bg-light">
        <div class="card-body">
            <h5 class="card-body">Interests</h5>
            <?php

            $user_interests = get_user_interests($user_profile['id']);
            foreach ($user_interests as $interest) {
                ?>

                <span class="badge rounded-pill bg-secondary"><?= $interest ?></span>

                <?php
            }
            ?>

        </div>
    </div>
    <?php

}

?>
<div class="container">
    <div class="row">
        <div class="d-none d-md-flex col-md-1 p-1 align-items-center">
            <a href="javascript:dislikeUser(<?= 'test' ?>);">
                <img src="resources/dislike_bottle.png"
                     alt="like button"
                     class="img-fluid align-middle"
                />
            </a>

        </div>

        <div class="col-12 col-sm-4">
            <img src="resources/3.jpg"
                 alt="user image"
                 class="rounded-3 img-fluid max-height mx-auto d-block "
            />
            <!--            <img src="--><?php //= get_user_images($user_id) ?><!--"-->
        </div>
        <div class="d-none d-md-flex col-md-1 p-1 align-items-center">
            <a href="javascript:likeUser(<?= 'test' ?>);">
                <img src="resources/like_bottle.png"
                     alt="like button"
                     class="img-fluid"
                />
            </a>
        </div>
        <div class="col-12 col-sm-6 d-sm-flex align-items-center">
            <div style="width: 100%;">
                <?php
                bio_card($suggested_user_profile);
                interest_card($suggested_user_profile);
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>