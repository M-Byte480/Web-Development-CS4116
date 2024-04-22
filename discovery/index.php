<?php
// Validate is user logged in
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/images.php');

try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

require_once(__DIR__ . "/../database/repositories/profile_pictures.php");


if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = 'null';
}

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
<?php require_once(__DIR__ . '/../nav_bar/index.php') ?>

<?php

require_once(__DIR__ . '/discovery_functions.php');
require_once(__DIR__ . '/../database/repositories/interests.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
//$user = get_user_from_cookies()->fetch_assoc(); // Creates assoc array so we use [] accessors

// todo: use this are a reference to get potential matches
$clicked_user = get_user_profile($user_id);


$potential_matches_ids = get_potential_matching_profiles($user_id);


function bio_card($user_profile): void
{
    ?>
    <div class="bio card m-2 bg-light">
        <div class="card-body ">
            <h5 class="card-body">About <?= get_first_name_from_user_ID($user_profile['userId']) ?></h5>
            <p class="card-text text-center">
                <?= $user_profile['description'] ?>
            </p>
        </div>
    </div>
    <?php
}

function interest_card($user_profile): void
{
    ?>
    <div class="interests card m-2 bg-light">
        <div class="card-body">
            <h5 class="card-body">Interests</h5>
            <?php
            $user_interests = get_user_interests($user_profile['userId']);
            foreach ($user_interests as $interest) {
                ?>
                <span class=" badge rounded-pill bg-secondary"><?= $interest ?></span>

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
        <div class="col-12 col-sm-4 mt-2">
            <div id="userImagesCarousel" class="carousel slide">

                <?php
                $images = get_images_by_user_id($user_id);
                $total_images = count($images);
                if ($total_images < 1) {
                    $images = array('../resources/search/default_image.jpg');
                }
                ?>

                <div class="carousel-inner">
                    <?php for ($i = 0; $i < count($images); $i++) {
                        $image = $images[$i];
                        ?>

                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <img src="<?= $total_images < 1 ? $image : 'data:image/png;base64,' . $image['image']; ?>"
                                 class="d-block w-100"
                                 alt="">
                        </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-next" type="button" data-bs-target="#userImagesCarousel"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="false"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <button class="carousel-control-prev" type="button" data-bs-target="#userImagesCarousel"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="false"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
            </div>

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
                bio_card($clicked_user);
                interest_card($clicked_user);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

