<!doctype html>
<html lang="en">
<head>
    <!-- Bootstrap CSS-->
    <?php require_once("../imports.php") ?>
    <link rel="stylesheet" href="styles.css">
    <title>Signup</title>
</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/toastmaker/dist/toastmaker.min.css">
<script type="text/javascript" src="https://unpkg.com/toastmaker/dist/toastmaker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signup').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'signup_backend.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);
                    if (jsonData.success === 1) {

                        window.location.href = "../login/";
                    } else {
                        let msg = jsonData['errors'].join(', ');
                        const errors = new ToastMaker(msg, 3000);
                        errors.show();
                    }
                }
            });
        });
    });
</script>

<div style="background-color: orange">
    <div class="row2">
        <div class="container bg-light ">
            <form class="form" action="signup_backend.php" method="post" id="signup">
                <div class="row">
                    <div class="col-12">
                        <p class="h1 text-dark" style="text-align: center;">SIGNUP</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="text-danger
            ">* required field </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="text-dark" for="user_email">Email Address <small
                                    class="text-danger">*</small></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <input name="user_email" id="user_email" type="email" class="form-control"
                               placeholder="Enter email"
                               required>
                        <!--                        <small class="text-danger">[Email must follow xxx@xxx.xxx Format]</small>-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="text-dark" for="user_first_name">First Name <small
                                    class="text-danger">*</small></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <input pattern="[\w'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,30}" name="user_first_name"
                               id="user_first_name" type="text"
                               class="form-control"
                               title="Please enter a valid input containing only letters (a-z, A-Z) and spaces, with a length between 2 and 30 characters."
                               placeholder="Enter your first name" required maxlength="70">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="text-dark" for="user_second_name">Second Name<small
                                    class="text-danger">*</small></label>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <input pattern="[\w'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,30}"
                               title="Please enter a valid input containing only letters (a-z, A-Z) and spaces, with a length between 2 and 30 characters."
                               name="user_second_name"
                               id="user_second_name"
                               type="text" class="form-control"
                               placeholder="Enter your surname" required maxlength="70">
                    </div>
                </div>

                <!-- Input Password-->
                <div class="row">
                    <div class="col-12">
                        <label class="text-dark" for="user_password">Password<small
                                    class="text-danger">*</small></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <input name="user_password" id="user_password" type="password" class="form-control"
                               placeholder="Password" minlength="8" maxlength="35">
                        <small class="text-danger">[Password may not contain special characters]</small>
                    </div>
                </div>

                <!-- Validate Password-->
                <div class="row">
                    <div class="col-12">
                        <label class="text-dark" for="password_confirmation">Confirm Password <small
                                    class="text-danger">*</small></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <input name="password_confirmation"
                               id="password_confirmation" type="password"
                               class="form-control"
                               placeholder="Re-enter your password" required minlength="8" maxlength="35">
                    </div>
                </div>

                <!-- Input Date of Birth -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p class="text-dark">Enter your birthday<small class="text-danger"> *</small></p>
                    </div>

                    <div class="col-12 col-md-6">
                        <p class="text-dark">Sex<span class="text-danger"> *</span></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <input name="user_dob" type="date" pattern="\d{4}-\d{2}-\d{2}"
                               value="0000-00-00" min="1920-01-01"
                               required><br>
                        <small class="text-danger"> [User must be 18+]</small>
                    </div>
                    <script>
                        var maxDate = new Date();
                        maxDate.setFullYear(maxDate.getFullYear() - 18);
                        var formattedMaxDate = maxDate.toISOString().split('T')[0];
                        document.querySelector('input[name="user_dob"]').setAttribute('max', formattedMaxDate);
                    </script>

                    <!-- Input Gender  -->
                    <div class="col-12 col-md-6">
                        <input type="radio" id="gender" name="gender" value="Male">
                        <label class="text-dark">Male</label>
                        <input type="radio" id="gender" name="gender" value="Female">
                        <label class="text-dark">Female</label>
                        <input type="radio" id="gender" name="gender" value="Other">
                        <label class="text-dark">Other</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary h1">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>


</html>




