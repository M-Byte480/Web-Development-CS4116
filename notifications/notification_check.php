<?php require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/notifications.php");

?>
<?php if (!empty(check_for_nofication(get_user_id_by_email($_COOKIE["email"])))) {
    ?>
    <div id="popup"
         style="display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); z-index: 9999;">
        <h2> You have new notifications!</h2>
        <p> Click the button below to check them .</p>
        <button onclick="location.href = '../notifications';"> Check Notifications</button>
    </div>
<?php }
?>
