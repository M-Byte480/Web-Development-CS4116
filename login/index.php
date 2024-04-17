<!doctype html>
<html lang="en">
<head>
    <?php
    require_once(__DIR__ . "/../imports.php")
    ?>


    <link rel="stylesheet" href="styles.css">

    <title>Login</title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/toastmaker/dist/toastmaker.min.css">
<script type="text/javascript" src="https://unpkg.com/toastmaker/dist/toastmaker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#loginForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: './login.php',
                data: $(this).serialize(),
                success: function (response) {
                    const jsonData = JSON.parse(response);
                    if (jsonData['success'] === 1) {
                        window.location.href = "../profile/";
                    } else {
                        let msg = jsonData['alerts'];
                        const errors = new ToastMaker(msg, 3000);
                        errors.show();
                    }
                }
            });
        })
        ;
    });
</script>

<div class="vh-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 text-black">

                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5">
                    <form id="loginForm" method="post" style="width: 23rem;">
                        <h2 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log-In</h2>

                        <?php if (isset($_GET['error'])) { ?>

                            <p class="error"><?php echo $_GET['error']; ?></p>

                        <?php } ?>

                        <div class="form-outline">
                            <label for="Emailinput" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="Emailinput" aria-describedby="emailHelp"
                                   name="email">
                        </div>

                        <div class="form-outline">
                            <label for="Passwordinput" class="form-label">Password</label>
                            <input type="password" class="form-control" id="Passwordinput" name="password"
                                   aria-describedby="passwordHelp">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn btn-dark mt-3">LOGIN
                            </button>
                        </div>

                        <p class="pt-3">Don't have an Account?
                            <a href="../signup/" class="link-info">Register Now</a></p>

                    </form>

                </div>

            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="../resources/login/3D_animated_beer_background.gif"
                     alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
        </div>
    </div>

</div>


</body>
</html>
<?php