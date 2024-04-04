<?php
// Validate is user logged in
require_once(__DIR__ . '/../validator_functions.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

$interest_flag = isset($_GET['interests']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require_once(__DIR__ . '/../css_binding.php'); ?>
    <link rel="stylesheet" href="styles.css">

    <title>Search</title>
</head>
<body>

<?php require_once(__DIR__ . '/../nav_bar/index.php'); ?>

<?php
require_once(__DIR__ . '/search_functions.php');

$searched_profiles = get_user_by_matches($_GET);

$user_count = mysqli_num_rows($searched_profiles);

?>

<div class="container">
    <div class="row">
        <?php
        require_once(__DIR__ . '/profile_card.php');
        while ($row = mysqli_fetch_assoc($searched_profiles)) {
            ?>
            <div class="col-12 col-md-3">
                <?php get_profile_card($row, $interest_flag) ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>


</body>
</html>
