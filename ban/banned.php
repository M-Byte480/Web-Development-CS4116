<!doctype html>
<html lang="en">
<head>
    <?php
    require_once(__DIR__ . "/../imports.php");
    require_once(__DIR__ . "/ban_functions.php");
    ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<section class="py-5 min-vh-100">
    <div class="container-lg justify-content-center align-items-center flex-column text-center w-100">
        <div>
            <img src="../resources/banned/bannedimage.jpg" class="img-fluid " alt="banned">
        </div>
        <div>
            <h1 class="display-1">You just got BANNNED Kid</h1>
            <h5 class="display-6">Take your pints and leave!!</h5>
        </div>
        <div>
            <?php
            $ban = get_recent_ban_of_this_user();
            display_ban_duration($ban);
            ?>
        </div>
    </div>
</section>
</body>
</html>