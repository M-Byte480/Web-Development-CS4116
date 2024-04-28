<?php
require_once("../imports.php");
require_once(__DIR__ . "/../database/repositories/notifications.php");

?>
<html>
<head>

    <link rel="stylesheet" href="styles.css">
    <title>Notifications</title>
</head>
<body>
<?php
require_once(__DIR__ . "/../nav_bar/index.php");

// Get user ID
$userId = get_user_id_by_email($_COOKIE["email"]);
$notifications = get_all_notifcations($userId);
// Get notifications for the user

?>
<script>
    document.getElementById('popup').style.display = 'none';

    function home_clear() {
        let postData = {
            "notification": {
                "userId": "<?= $userId ?>"
            }
        };
        $.ajax({
            type: "POST",
            url: "notification_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
                window.location.href = "../home/";
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('fuck');
                alert(thrownError);
            }
        });
    }

</script>
<button onclick="home_clear()">Return to home</button>
<div style="margin-top: 20px">
    <?php while ($notification = $notifications->fetch_assoc()): ?>
        <div class="notification-container">
            <p class="notification-text"><?php echo($notification['reason']) ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
