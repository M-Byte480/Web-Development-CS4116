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

<?php
// Assuming you have already connected to your database
require_once(__DIR__ . '/../secrets.settings.php'); // Include database connection settings

// Get the email variable from the frontend (assuming it's passed via cookie)
$email_variable = $_COOKIE['email'];

// Initialize variables
$id = null;
$liked_users = array();
$disliked_users = array();

// Connect to the database
global $db_host, $db_username, $db_password, $db_database;
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

// Check for connection errors
if ($mysqli->connect_errno) {
    die("Connection Error: " . $mysqli->connect_error);
}

// Query to fetch the user's ID based on email
$query = "SELECT id FROM users WHERE email = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $email_variable);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
$stmt->close();

// Query to fetch liked users
$query = "SELECT likedUser FROM likes WHERE userId = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($liked_user);
while ($stmt->fetch()) {
    $liked_users[] = $liked_user;
}
$stmt->close();

// Query to fetch disliked users
$query = "SELECT dislikeUser FROM dislikes WHERE userId = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($disliked_user);
while ($stmt->fetch()) {
    $disliked_users[] = $disliked_user;
}
$stmt->close();

// Close the database connection
$mysqli->close();
$rows = [];

?>

<div class="container">
    <div class="row">
        <?php
        require_once(__DIR__ . '/profile_card.php');
        foreach ($rows as $row) {
            ?>
            <div class="col-12 col-md-3 user_card">
                <?php get_profile_card($row, $interest_flag) ?>
            </div>
            <?php
        }

        ?>
    </div>
</div>

<script>
    let count = 0;

    function newMatchesOnly() {
        const likedUsers = <?php echo json_encode($liked_users); ?>;
        const dislikedUsers = <?= json_encode($disliked_users); ?>;
        const mutual = likedUsers.concat(dislikedUsers);

        while ($row = get_user_by_matches($_GET)->
        fetch_assoc()
    )
        {
            $rows[] = $row;
        }
        const all = <?php echo json_encode($rows); ?>;
        var filterArray = all.filter((element) => {
            return mutual.indexOf(element) === -1;
        });

        if (count % 2 !== 0) {
            count++
            (document).querySelector('.change').innerHTML = "New Matches Only";
            Array.from((document).getElementsByClassName('user_card')).forEach((element) => {
                if (!filterArray.id.includes($(this).id)) {
                    (this).show();
                } else {
                    (this).hide();
                }
            });

        } else {
            count++
            (document).querySelector('.change').innerHTML = "See all Users";
            Array.from((document).getElementsByClassName('user_card')).forEach((element) => {
                if (!all.id.includes(element.id)) {
                    (this).show();
                } else {
                    (this).hide();
                }
            });

        }

    }
</script>
<p>

</p>
<div class="container">
    <button class="change" type="button" onclick="newMatchesOnly()">New Matches Only</button>
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
