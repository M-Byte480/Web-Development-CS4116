<?php
// Validate is user logged in
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../validate_user_logged_in.php');

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
<?php
require_once(__DIR__ . '/../nav_bar/index.php');
?>

<div class="container">
    <div class="row">
        <div class="d-flex align-items-center justify-content-center " style="height: 75px;">
            <div class="form-floating m-2">
                <input id="searchBar" size=30 type="text" class="form-control search-bar" placeholder="Search Users">
                <label for="searchBar">Search Users</label>
            </div>
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

<div class="container" id="users_container">
</div>

<script>
    let stop_displaying_users = false;

    function display_users() {
        if (stop_displaying_users)
            return;
        stop_displaying_users = true;
        setTimeout(() => {
            stop_displaying_users = false;
        }, 250);

        let searchText = $("#searchBar").val().toLowerCase();

        let postData = {
            "name": searchText,
            "interestFlag": "<?= $interest_flag ?>",
            "getRequest": <?= json_encode($_GET) ?>
        };
        $.ajax({
            type: "POST",
            url: "search_result_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
                document.getElementById("users_container").innerHTML = response
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    $(document).ready(function () {
        display_users();
        $('#searchBar').on('input', function () {
            display_users();
        });
    });
</script>
</body>
</html>
