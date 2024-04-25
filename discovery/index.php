<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/images.php');
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
$logged_in_user = validate_user_logged_in();

$GET_REQUEST = true;

if (isset($_GET['user_id'])) {
    $affected_user_id = $_GET['user_id'];
} else {
    $GET_REQUEST = false;
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
    require_once(__DIR__ . "/../imports.php");
    ?>
    <link rel="stylesheet" href="styles.css">

    <title>Discovery</title>

</head>

<script>
    function getToast(msg) {
        return `<div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Match Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${msg}
                </div>
            </div>
        </div>`
    }

    function post_connection(postData) {

        $.ajax({
            type: "POST",
            url: "discovery_backend.php",
            data: {
                'json': JSON.stringify(postData)
            },
            success: function (response) {
                let json = JSON.parse(response)
                if (json.length > 0) {
                    let toastHTML = getToast(json);
                    $(document.body).append(toastHTML);
                    $('.toast').toast('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('fuck');
                alert(thrownError);
            }
        });
    }

    function dislikeUser(userId) {
        let postData = {
            "discovery_action": {
                "action": "dislike",
                "user_id": "<?= $logged_in_user['id'] ?>",
                "affected_user": userId
            }
        };
        post_connection(postData);
    }

    function likeUser(userId) {
        let postData = {
            "discovery_action": {
                "action": "like",
                "user_id": "<?= $logged_in_user['id'] ?>",
                "affected_user": userId
            }
        };
        post_connection(postData);
    }
</script>
<body>
<?php require_once(__DIR__ . '/../nav_bar/index.php') ?>

<?php

require_once(__DIR__ . '/discovery_functions.php');
require_once(__DIR__ . '/../database/repositories/interests.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');

if (!$GET_REQUEST) {
    $potential_matches = get_potential_matching_profiles();
    // Todo: check for how many users

    $num_p_matches = count($potential_matches);
    if ($num_p_matches < 1) {
        header('Location: ./get_a_life/');
        exit();
    }
    echo 'Potential Matches: ' . $num_p_matches . '<br>';
    $this_user_profile = $potential_matches[0];
    $affected_user_id = $this_user_profile['id'];
} else {
    $this_user_profile = get_user_profile_for_discovery($affected_user_id);

    $this_user_profile['id'] = $this_user_profile['userId'];
}

function bio_card($user_profile): void
{
    ?>
    <div class="bio card m-2 bg-light">
        <div class="card-body ">
            <h5 class="card-body">
                About <?= get_first_name_from_user_ID($user_profile['id']) . ' ' . get_last_name_from_user_ID($user_profile['id']) ?></h5>
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
            $user_interests = get_user_interests($user_profile['id']);
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
            <a href="javascript:dislikeUser('<?= $affected_user_id ?>');">
                <img src="resources/dislike_bottle.png"
                     alt="like button"
                     class="img-fluid align-middle"
                />
            </a>
        </div>
        <div class="col-12 col-sm-4 mt-2">
            <div id="userImagesCarousel" class="carousel slide">

                <?php
                $images = get_images_by_user_id($affected_user_id,);
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
            <a href="javascript:likeUser('<?= $affected_user_id ?>');">
                <img src="resources/like_bottle.png"
                     alt="like button"
                     class="img-fluid"
                />
            </a>
        </div>
        <div class="col-12 col-sm-6 d-sm-flex align-items-center">
            <div style="width: 100%;">
                <?php
                bio_card($this_user_profile);
                interest_card($this_user_profile);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

