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
<section class="py-3 py-md-5 min-vh-100 justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div>
                        <img src="../resources/banned/bannedimage.jpg" class="img-fluid " alt="banned">
                    </div>
                    <div>
                        <h1 class="display-1 ">You just got BARRED Kid</h1>
                        <h5 class="display-6">Take your pints and leave!!</h5>
                    </div>
                    <div>
                        <?php
                        $ban = get_recent_ban_of_this_user();
                        display_ban_days_duration($ban);
                        ?>
                    </div>

                    <div>
                        <?php
                        display_ban_time_duration($ban);
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>