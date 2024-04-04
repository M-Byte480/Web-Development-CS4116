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
        }
    </style>
</head>
<body>
<?php require_once("../nav_bar/index.php"); ?>

<div class="row m-3 p-3">
    <div class="col-sm-4 col-12 p-3">
        <div class="ratio ratio-1x1">
            <img src="<?= get_user_pfp_from_user_ID($user_ID) ?>" alt="Profile Picture"
                 class="img-fluid">
        </div>
    </div>
    <div class="col-sm-8 col-12 p-1 my-auto text-center">
        <h1 class="d-inline p-3"><?php echo get_first_name_from_user_ID($user_ID) ?? "No name :("; ?>,</h1>
        <h1 class="d-inline p-3"><?php echo get_age_from_user_ID($user_ID) ?></h1>
    </div>
</div>
<div class="row m-3 p-3 justify-content-center text-center text-sm-start">
    <div class="col-sm-4 col-12 p-1">
        <div class="bg-secondary rounded-3 p-3 h-100">
            <h2>My Pictures</h2>
        </div>
    </div>
    <div class="row col-sm-8 col-12 px-0 px-md-1 m-0">
        <div class="col-12 p-1">
            <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                <h2>About Me</h2>
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
        <div class="col-sm-4 col-12 p-1">
            <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                <h2>Go To Drink</h2>
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
        <div class="col-sm-4 col-12 p-1">
            <div class="bg-secondary rounded-3 p-3 position-relative">
                <h2>My Interests</h2>
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
        <div class="col-sm-4 col-12 p-1">
            <div class="bg-secondary rounded-3 p-3 h-100 position-relative">
                <h2>Looking For</h2>
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
</body>

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
