<?php
// Validate is user logged in
header('Pragma: no-cache');
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/images.php');
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
$logged_in_user = validate_user_logged_in();

$SEARCH = true;

if (isset($_GET['user_id'])) {
    $affected_user_id = $_GET['user_id'];
} else {
    $SEARCH = false;
}


require_once(__DIR__ . '/discovery_functions.php');
require_once(__DIR__ . '/../database/repositories/interests.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
require_once(__DIR__ . '/algorithm.php');


if (!$SEARCH) {

    $potential_matches = get_best_fit_users($logged_in_user);
    $ppm = array();
    while ($pop = $potential_matches->fetch_assoc()) {
        $ppm[] = $pop;
    }

    $num_p_matches = count($ppm);

    if ($num_p_matches < 1) {
        header('Location: ./no-more-suggestions.php');
        exit();
    }


    $this_user_profile = array_values($ppm)[0];
    $affected_user_id = $this_user_profile['id'];
} else {
    $this_user_profile = get_user_profile_for_discovery_better($affected_user_id);

    $this_user_profile['id'] = $this_user_profile['userId'];
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
    var timeOut = 1_000;
    var discovery = <?php echo $SEARCH != 0 ? 'false' : 'true' ?>;

    function disableButtons() {
        document.getElementById('likeBtn').style.pointerEvents = "none";
        document.getElementById('likeBtn').style.cursor = "default";

        document.getElementById('dislikeBtn').style.pointerEvents = "none";
        document.getElementById('dislikeBtn').style.cursor = "default";

        document.getElementById('likeBtn').classList.add("disabled");
        document.getElementById('dislikeBtn').classList.add("disabled");
    }

    function enableButtons() {
        document.getElementById('likeBtn').style.pointerEvents = "auto";
        document.getElementById('likeBtn').style.cursor = "pointer";

        document.getElementById('dislikeBtn').style.pointerEvents = "auto";
        document.getElementById('dislikeBtn').style.cursor = "pointer";

        document.getElementById('likeBtn').classList.remove("disabled");
        document.getElementById('dislikeBtn').classList.remove("disabled");
    }

    function getToast(msg, type) {
        return `<div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">${type}</strong>
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
                if (response !== "") {
                    let toastHTML = getToast(response, "New Connection");
                    $(document.body).append(toastHTML);
                    $('.toast').toast('show');
                }

                if (discovery) {
                    disableButtons();

                    setTimeout(() => {
                        location.reload();
                    }, timeOut);
                } else {
                    disableButtons();

                    setTimeout(() => {
                        enableButtons();
                    }, 1_500);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
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
        if (discovery) {
            document.getElementById('dislike-pop').classList.remove("d-none");
            document.getElementById('dislike-pop').classList.add("d-block");
        } else {
            document.getElementById('dislike-pop').classList.remove("d-none");
            document.getElementById('dislike-pop').classList.add("d-block");

            setTimeout(() => {
                document.getElementById('dislike-pop').classList.add("d-none");
                document.getElementById('dislike-pop').classList.remove("d-block");
            }, 1_000);
        }

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

        if (discovery) {
            document.getElementById('like-pop').classList.remove("d-none");
            document.getElementById('like-pop').classList.add("d-block");
        } else {
            document.getElementById('like-pop').classList.remove("d-none");
            document.getElementById('like-pop').classList.add("d-block");

            setTimeout(() => {
                document.getElementById('like-pop').classList.add("d-none");
                document.getElementById('like-pop').classList.remove("d-block");
            }, 1_550);
        }

        post_connection(postData);
    }

    function reportUser(userId) {
        let postReportData = {
            "report_action": {
                "report": document.getElementById("report_reason").value,
                "user_id": "<?= $logged_in_user['id'] ?>",
                "affected_user": userId
            }
        };
        post_report(postReportData);
    }

    function post_report(postReportData) {
        disableButtons();

        $.ajax({
            type: "POST",
            url: "discovery_report_backend.php",
            data: {
                'json': JSON.stringify(postReportData)
            },
            success: function () {
                let msg = "User reported sucessfully !"
                let toastHTML = getToast(msg, "New Report");
                $(document.body).append(toastHTML);
                $('.toast').toast('show');

                setTimeout(() => {
                    location.reload();
                }, 750);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

</script>
<body>
<?php require_once(__DIR__ . '/../nav_bar/index.php') ?>
<!--Report Modal-->
<div class="modal fade" id="reportModal" role="alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="modal-body" method="post" action="" id="reportForm">
                <button type="button" class="exit" data-bs-dismiss="modal">&times</button>
                <h2 class="modal-title">Give a reason for reporting!</h2>
                <div class="mb-2">
                    <label for="report_reason" class="form-label">Reason</label>
                    <textarea class="form-control" id="report_reason" name="report_reason"
                              rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-danger" onclick="reportUser('<?= $affected_user_id ?>');">
                    Report
                </button>
            </form>
        </div>
    </div>
</div>
<?php

function bio_card($user_profile): void
{
    require_once(__DIR__ . '/../search/profile_card.php');
    require_once(__DIR__ . '/../database/repositories/beverages.php');
    require_once(__DIR__ . '/../database/repositories/users.php');
    ?>
    <div class="bio card m-2 bg-light">
        <div class="card-body">
            <h5 class="card-body">
                About
                <div class="row">
                    <div class="col-6 italics fst-italic">
                        <?= get_first_name_from_user_ID($user_profile['id']) . ' ' . get_last_name_from_user_ID($user_profile['id']) ?>
                    </div>
                    <div class="col-6 text-right fst-italic">
                        <?= $user_profile['favouriteBeverage'] ?? get_users_beverage_from_user_ID($user_profile['userId']) ?>
                        Drinker
                    </div>
                </div>
                <div class="row">

                    <div class="col-6">
                        <?= get_user_age($user_profile) ?>
                    </div>
                    <div class="col-6 text-right fst-italic">
                        <?= $user_profile['gender'] ?>
                    </div>
                </div>
            </h5>
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
            <a href="javascript:dislikeUser('<?= $affected_user_id ?>');" id="dislikeBtn">
                <img src="resources/dislike_bottle.png"
                     alt="like button"
                     class="img-fluid align-middle bottle"
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
            <div class="d-block d-sm-none">

                <div class="row">
                    <div class="col-auto me-auto">
                        <a href="javascript:dislikeUser('<?= $affected_user_id ?>');"
                           id="dislikeBtn">
                            <img src="resources/dislike_bottle.png"
                                 alt="like button"
                                 class="img-fluid align-middle bottle bottle-small"/>
                        </a></div>
                    <div class="col-auto">
                        <a href="javascript:likeUser('<?= $affected_user_id ?>');" id="likeBtn">
                            <img src="resources/like_bottle.png"
                                 alt="like button"
                                 class="img-fluid bottle bottle-small"/>
                        </a></div>
                </div>
            </div>
        </div>

        <div class="d-none d-md-flex col-md-1 p-1 align-items-center">
            <a href="javascript:likeUser('<?= $affected_user_id ?>');" id="likeBtn">
                <img src="resources/like_bottle.png"
                     alt="like button"
                     class="img-fluid bottle "
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
    <button href="#" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#reportModal">Report
    </button>

</div>

<div class="position-absolute text-center align-middle border d-flex align-items-center justify-content-center h-100 w-100 start-0 top-0 d-none"
     id="like-pop">
    <div style="width: 100vw; height: 100vh; "
         class="like-button  d-flex align-items-center justify-content-center">
        LIKED YUUURT
    </div>
</div>

<div class="position-absolute text-center align-middle border d-flex align-items-center justify-content-center h-100 w-100 start-0 top-0 d-none"
     id="dislike-pop">
    <div style="width: 100vw; height: 100vh; "
         class="dislike-button  d-flex align-items-center justify-content-center">
        DISLIKED BOO
    </div>
</div>

</body>
</html>

