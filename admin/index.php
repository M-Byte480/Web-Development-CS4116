<?php
// Validate is user logged in
require_once(__DIR__ . '/../validators.php');
try {
    validate_user_logged_in();
    validate_user_is_admin();
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
    <title>PubClub Admin</title>

</head>
<body>


<?php

// Import navigation bar
require_once(__DIR__ . "/../NavBar/index.php");


function action_button($user): void
{
    ?>
    <div class="dropdown">
        <div class="mobile-menu-toggle">
            <button class="btn btn-danger dropdown-toggle mobile-toggle-btn btn-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu">

                <li class="dropdown-item">
                    <form id="banForm" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="banned_by_email" value="<?= $_COOKIE['email'] ?>">
                        <input type="hidden" name="action" value="ban">
                        <input type="submit" name="banBtn" id="banBtn" value="Ban User"/>
                    </form>
                </li>
                <li class="dropdown-item">
                    <form id="removeBio" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="action" value="remove_id">
                        <input type="submit" name="banBtn" id="removeBioBtn" value="Remove Bio"/>
                    </form>
                </li>
                <li class="dropdown-item">
                    <form id="removePfp" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="action" value="remove_pfp">
                        <input type="submit" name="banBtn" id="banBtn" value="Remove PFP"/>
                    </form>
                </li>
                <li class="dropdown-item">
                    <form id="removeAllImages" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="action" value="remove_all_images">
                        <input type="submit" name="banBtn" id="banBtn" value="Remove All images"/>
                    </form>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <form id="removeForm" method="post" action="admin_backend.php">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="banned_by_email" value="<?= $_COOKIE['email'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="submit" name="removeBtn" id="removeBtn" value="Delete"/>
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php
}

function pfp($user): void
{
    ?>
    <img src="<?= get_user_pfp($user) ?>"
         alt="Profile Picture"
         class="img-fluid rounded-circle"
         style="width: 100px; height: 100px; object-fit: cover;"
    >
    <?php
}

include_once(__DIR__ . '/admin_functions.php');

function user_information($user): void
{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h4><?= get_user_name($user) ?> | <?= get_user_age($user) ?></h4>
            </div>
            <div class="col-md-6">Reports: <?= $user['reportCount'] ?>
            </div>
        </div>
    </div>
    <?php
}

// Query Database
$usersInDb = get_all_users();

foreach ($usersInDb as $user) {
    ?>
    <div class="container ">
        <div class=" row align-items-center height-100px mt-3 border curve-100 bg-gray ">
            <div class="col-2 col-sm-2 col-md-2 p-1 width-100px">
                <?php pfp($user) ?>
            </div>
            <div class="col-8 col-sm-8 col-md-8">
                <?php user_information($user) ?>
            </div>
            <div class="col-2 col-sm-2 col-md-2 text-md-right">
                <?php action_button($user) ?>
            </div>
        </div>
    </div>

    <?php
}
?>

<script type="text/javascript">
    // Ban User
    $(document).ready(function () {
        $('#banForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'admin_backend.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    if (jsonData.success == "1") {
                        alert('User has been Banned!');
                    } else {
                        alert('Failed To Ban!');
                    }
                }
            });
        });
    });

    // Remove User
    $(document).ready(function () {
        $('#removeForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'admin_backend.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    if (jsonData.success == "1") {
                        alert('User has been Removed!');
                    } else {
                        alert('Failed To Remove!');
                    }
                }
            });
        });
    });
</script>
</body>
</html>
