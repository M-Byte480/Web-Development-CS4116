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
    <style>
        .timer {
            color: red;
        }

        body {
            border: 6px solid orangered;
        }

    </style>
</head>
<body>

<section class="py-5 py-md-5 min-vh-100 justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div>
                        <img src="../resources/banned/bannedimage.jpg" class="img-fluid " alt="banned">
                    </div>
                    <div>
                        <h1 class="display-1">You just got BARRED Kid</h1>
                        <h5 class="display-6">Take your pints and leave!!</h5>
                    </div>

                    <span id="countdown" class="timer display-3"></span>

                    <?php
                    $ban = get_recent_ban_of_this_user();
                    $banEndDate = new DateTime($ban['endDate']);
                    $now = new DateTime();
                    $interval = $banEndDate->getTimestamp() - $now->getTimestamp();
                    $isPermanent = $ban['permanent'];
                    ?>

                    <script type="text/javascript">

                        var seconds = <?php echo $interval; ?>;
                        var isPermanent = <?php echo $isPermanent ? 'true' : 'false'; ?>;


                        function timer() {
                            if (isPermanent) {
                                document.getElementById('countdown').innerHTML = "YOU ARE PERMA BANNED";
                                clearInterval(countTimer);
                                exit();
                            }
                            var days = Math.floor(seconds / 24 / 60 / 60);
                            var hours = Math.floor(seconds / 60 / 60);
                            var minutesLeft = Math.floor((seconds) - (hours * 3600));
                            var minutes = Math.floor(minutesLeft / 60);
                            var secondsLeft = seconds % 60;

                            document.getElementById('countdown').innerHTML = days + " days " + hours % 24 + " hours " + minutes + " minutes " + secondsLeft + " seconds ";
                            if (seconds <= 0) {
                                clearInterval(countTimer);
                                window.location = "Location: ./index.php";
                            } else {
                                seconds--;
                            }
                        }

                        var countTimer = setInterval(timer, 1000);
                        timer();
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>