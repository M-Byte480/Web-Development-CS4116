<?php
// Validate is user logged in
require_once(__DIR__ . '/../validator_functions.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

require_once(__DIR__ . '/../database/repositories/likes.php');
require_once(__DIR__ . '/../database/repositories/dislikes.php');
require_once(__DIR__ . '/profile_card.php');
require_once(__DIR__ . '/search_functions.php');

$interest_flag = isset($_GET['interests']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require_once(__DIR__ . '/../imports.php'); ?>
    <link rel="stylesheet" href="styles.css">

    <title>Search</title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php

require_once(__DIR__ . '/../nav_bar/index.php');

$searched_profiles = get_user_by_matches($_GET);
$user_count = mysqli_num_rows($searched_profiles);

// Get the email variable from the frontend (assuming it's passed via cookie)
$email_variable = $_COOKIE['email'];


$user_id = get_user_id_by_email($email_variable);

$liked_users = get_all_liked_user_by_user_id($user_id);

$disliked_users = get_all_disliked_user_by_user_id($user_id);

$union_users = array_merge($liked_users, $disliked_users);


$rows = [];

while ($row = mysqli_fetch_assoc($searched_profiles)) {
    $rows[] = $row;
}

$completement_users = @array_diff($rows, $union_users);

?>

<script>
    let showAllUsersFlag = true;

    function newMatchesOnly() {
        console.log("click");
        showAllUsersFlag = !showAllUsersFlag;

        if (showAllUsersFlag) {
            (document).getElementById('searchBar').disabled = false;

            (document).querySelector('#switch-state').innerHTML = "See all Users";

            (document).getElementById('all-users').style.display = 'block';
            (document).getElementById('complement-users').style.display = 'none';
        } else {
            (document).getElementById('searchBar').disabled = true;

            (document).querySelector('#switch-state').innerHTML = "New Matches Only";

            (document).getElementById('all-users').style.display = 'none';
            (document).getElementById('complement-users').style.display = 'block';
        }

    }
</script>

<div class="container">
    <div class="row">
        <div class="d-flex align-items-center justify-content-center " style="height: 75px;">
            <div class="m-2">
                <input id="searchBar" size="30" type="text" class="search-bar" placeholder="Search Users...">
            </div>

            <div class="form-check form-switch ml-2">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                       onclick="newMatchesOnly()">

            </div>
            <div id="switch-state" style="width: 150px;">All users</div>
        </div>
    </div>
</div>
<script>
    function onCardClicked(user_id) {
        // Open page with get request
        let getRequest = "?user_id=" + user_id;
        window.open("../discovery/" + getRequest, "_parent");
    }
</script>

<div class="container" id="all-users">
    <div class="row">
        <?php
        foreach ($rows as $row) {
            ?>

            <div class="col-12 col-md-3 user_card profiles">
                <?php get_profile_card($row, $interest_flag) ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="container" id="complement-users" style="display: none;">
    <div class="row">
        <?php
        require_once(__DIR__ . '/profile_card.php');
        foreach ($completement_users as $row) {
            ?>
            <div class="col-12 col-md-3 user-card">
                <?php get_profile_card($row, $interest_flag) ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#searchBar').on('input', function () {
            let searchText = $(this).val().toLowerCase();

            $('.profiles').each(function () {
                var userName = $(this).find('.user-name').text().toLowerCase();

                if (userName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
</body>
</html>
