<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user_logged_in.php');

require_once(__DIR__ . "/../database/repositories/beverages.php");
require_once(__DIR__ . "/../database/repositories/interests.php");
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/profiles.php");
require_once(__DIR__ . "/../database/repositories/images.php");

$user_ID = (string)get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];

if (isset($_GET['user_id'])) {
    $user_ID = $_GET['user_id'];
}

function display_interests(): void
{
    global $user_ID;
    $interests = get_user_interests_from_user_ID($user_ID);

    if (is_null($interests)) {
        echo("No interests :(");
        return;
    }

    foreach ($interests as $interest) {
        echo("<li>" . $interest . "</li>");
    }
}

function display_drink_options(): void
{
    global $user_ID;
    $bev_table = get_all_beverages();
    $uesrs_current_bev = get_users_beverage_from_user_ID($user_ID);

    foreach ($bev_table as $bev_row) {
        if ($uesrs_current_bev == $bev_row[1])
            echo("<option selected value=\"" . $bev_row[0] . "\">" . $bev_row[1] . "</option>");
        echo("<option value=\"" . $bev_row[0] . "\">" . $bev_row[1] . "</option>");
    }
}

function display_interests_options(): void
{
    global $user_ID;
    $interests_table = get_all_interests();
    $users_current_interests = get_user_interests_from_user_ID($user_ID);

    foreach ($interests_table as $interest_row) {
        echo("<div class=\"form-check form-check-inline m-1 p-0\">");
        if (in_array($interest_row[1], $users_current_interests))
            echo("<input type=\"checkbox\" class=\"btn-check\" name=\"edit_interests[]\" value=\"" . $interest_row[0] . "\" id=\"" . $interest_row[0] . "\" checked>");
        else
            echo("<input type=\"checkbox\" class=\"btn-check\" name=\"edit_interests[]\" value=\"" . $interest_row[0] . "\" id=\"" . $interest_row[0] . "\">");
        echo("<label class=\"btn btn-outline-primary\" for=\"" . $interest_row[0] . "\">" . $interest_row[1] . "</label>");
        echo("</div>");
    }
}

function display_user_pictures_in_carousel(): void
{
    global $user_ID;
    $users_pictures = get_images_by_user_id($user_ID);
    $first_image = true;

    echo("<div class=\"carousel-indicators\">");

    $image_counter = 0;
    foreach ($users_pictures as $users_pic) {
        echo("<button type=\"button\" data-bs-target=\"#carousel\" data-bs-slide-to=" . $users_pic['position'] . " ");
        if ($first_image) {
            echo("class=\"active\" aria-current=\"true\"");
            $first_image = false;
        }
        echo("></button>");
        $image_counter += 1;
    }
    echo("</div>");

    echo("<div class=\"carousel-inner\">");
    $first_image = true;
    foreach ($users_pictures as $users_pic) {
        if ($first_image) {
            echo("<div class=\"carousel-item active\">");
            $first_image = false;
        } else {
            echo("<div class=\"carousel-item\">");
        }
        echo("<img src=data:image/png;base64," . $users_pic['image'] . " class=\"img-fluid rounded-3 w-100\">");
        echo("</div>");
    }
    echo("</div>");
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
    </style>
</head>
<body>
<?php require_once("../nav_bar/index.php"); ?>

<div class="row flex-column-reverse flex-md-row m-3 p-3 text-center">
    <div class="col-sm-6 col-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100 pb-5 position-relative">
            <h4>My Pictures</h4>
            <div class="ratio" style="--bs-aspect-ratio: 177.78%">
                <div id="carousel"
                     class="carousel slide bg-black d-flex flex-wrap align-items-center rounded-3 overflow-hidden">
                    <?php display_user_pictures_in_carousel(); ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="position-absolute bottom-0 end-0">
                <div class="p-1">
                    <button type="button" name="delete_picture" class="btn btn-danger mx-1" data-bs-toggle="modal"
                            data-bs-target="#delete_picture">
                        <span class="me-1">Delete</span>
                        <i class="bi bi-archive"></i>
                    </button>
                    <button type="button" name="add_picture" class="btn btn-success mx-1" data-bs-toggle="modal"
                            data-bs-target="#add_picture">
                        <span class="me-1">Add</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-12 p-0">
        <div class="row p-0 m-0">
            <div class="col-sm-2 col-12 p-0">
            </div>
            <div class="col-sm-8 col-12 p-0">
                <div class="card text-center border border-0 p-1">
                    <div class="ratio ratio-1x1">
                        <img src="data:image/png;base64,<?= get_user_pfp_from_user_ID($user_ID) ?>"
                             alt="Profile Picture"
                             class="img-fluid object-fit-cover rounded-top-3">
                    </div>
                    <div class="card-body bg-secondary rounded-bottom-3">
                        <h5 class="card-text">
                            <?php echo get_first_name_from_user_ID($user_ID) ?? "No name :("; ?>,
                            <?php echo get_age_from_user_ID($user_ID) ?>
                        </h5>
                        <div class="position-absolute bottom-0 end-0">
                            <button type="button" name="edit_name_age" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#edit_name_age">
                                <span>Edit</span>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 m-0">
            <div class="col-sm-8 col-12 p-0">
                <div class="row p-0 m-0">
                    <div class="col-12 p-1">
                        <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                            <h4>About Me</h4>
                            <p>
                                <?php echo get_user_description_from_user_ID($user_ID) ?? "No bio :("; ?>
                            </p>
                            <div class="position-absolute bottom-0 end-0">
                                <button type="button" name="edit_bio" class="btn" data-bs-toggle="modal"
                                        data-bs-target="#edit_bio">
                                    <span>Edit</span>
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row p-0 m-0">
                        <div class="col-sm-6 col-12 p-1">
                            <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                                <h4>Go To Drink</h4>
                                <ul>
                                    <li><?= get_users_beverage_from_user_ID($user_ID) ?? "Water (boo)" ?></li>
                                </ul>
                                <div class="position-absolute bottom-0 end-0">
                                    <button type="button" name="edit_drink" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#edit_drink">
                                        <span>Edit</span>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 p-1">
                            <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                                <h4>Looking For</h4>
                                <ul> <?= get_user_seeking_from_user_ID($user_ID) ?? "Looking for help" ?>
                                </ul>
                                <div class="position-absolute bottom-0 end-0">
                                    <button type="button" name="edit_looking_for" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#edit_looking_for">
                                        <span>Edit</span>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12 p-1">
                <div class="bg-secondary rounded-3 p-3 position-relative h-100">
                    <h4>My Interests</h4>
                    <ul>
                        <?php display_interests() ?>
                    </ul>
                    <div class="position-absolute bottom-0 end-0">
                        <button type="button" name="edit_interests" class="btn" data-bs-toggle="modal"
                                data-bs-target="#edit_interests">
                            <span>Edit</span>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('#carousel').addEventListener('slid.bs.carousel', event => {
        document.querySelector("#delete_picture_input").setAttribute("value", event.to);
    });
</script>

<div class="modal fade" id="edit_bio">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php">
                    <div class="mb-3">
                        <label for="edit_bio" class="form-label"></label>
                        <input type="text" class="form-control" id="edit_bio" name="edit_bio"
                               value="<?php echo get_user_description_from_user_ID($user_ID) ?? "No bio :("; ?>">
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_drink">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php">
                    <div class="mb-3">
                        <label for="edit_drink"></label>
                        <select class="form-select" id="edit_drink" name="edit_drink">
                            <?php display_drink_options() ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_interests">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php">
                    <div class="mb-3 justify-content-center text-center">
                        <?php display_interests_options() ?>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_looking_for">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php">
                    <div class="mb-3 justify-content-center text-center">
                        <input type="radio" class="btn-check" name="edit_looking_for" value="Male"
                               id="edit_seeking_male" <?= get_user_seeking_from_user_ID($user_ID) == "Male" ? "checked" : "" ?>>
                        <label class="btn btn-outline-primary" for="edit_seeking_male">Male</label>

                        <input type="radio" class="btn-check" name="edit_looking_for" value="Female"
                               id="edit_seeking_female" <?= get_user_seeking_from_user_ID($user_ID) == "Female" ? "checked" : "" ?>>
                        <label class="btn btn-outline-primary" for="edit_seeking_female">Female</label>

                        <input type="radio" class="btn-check" name="edit_looking_for" value="Other"
                               id="edit_seeking_other" <?= get_user_seeking_from_user_ID($user_ID) == "Other" ? "checked" : "" ?>>
                        <label class="btn btn-outline-primary" for="edit_seeking_other">Other</label>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_name_age">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php">
                    <div class="mb-3">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label" for="edit_firstname">Change First Name</label>
                                <input type="text" class="form-control" name="edit_firstname"
                                       value="<?= get_first_name_from_user_ID($user_ID) ?? "No name :("; ?>"
                                       id="edit_firstname">
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="edit_lastname">Change Last Name</label>
                                <input type="text" class="form-control" name="edit_lastname"
                                       value="<?= get_last_name_from_user_ID($user_ID) ?? "No name :("; ?>"
                                       id="edit_lastname">
                            </div>
                        </div>

                        <label class="form-label" for="edit_age">Change Date of Birth</label>
                        <input type="date" class="form-control" name="edit_age"
                               value="<?= get_DOB_from_user_ID($user_ID) ?>"
                               id="edit_age">
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_picture">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="profile_backend.php" enctype="multipart/form-data">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title">Select a picture to add</h5>
                    </div>
                    <input class="form-control mb-3" type="file" name="add_picture"
                           accept=".jpg,.JPG,.jpeg,.JPEG,.png,.PNG,.gif,.GIF,.bmp,.BMP,.svg,.SVG,.webp,.WEBP">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_picture">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content ">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title">Are you sure you want to delete your picture?</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="profile_backend.php" class="d-flex justify-content-center">
                    <input id="delete_picture_input" class="form-control" type="text" name="delete_picture"
                           hidden="hidden" value="0">
                    <button type="button" class="btn btn-danger mx-3" data-bs-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-success mx-3" data-bs-dismiss="modal">Yes, delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
