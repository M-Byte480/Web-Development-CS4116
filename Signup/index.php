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

<div class="vh-100" style="background-image: linear-gradient(to bottom right, orangered, yellow)">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-5 px-0 d-none d-sm-block text-black">
                <img src="../resources/signup/signup.gif" alt="Sign-up gif" class="w-100 vh-100"
                     style="object-fit: cover; object-position: left;">
            </div>
            <div class="clearfix col-sm-7 text-black">
                <div class="d-flex justify-content-center align-items-center h-custom-3  ms-xl-4 mt-5 pt-5">
                    <form class="form" action="signup_backend.php" method="post" id="signup" style="width: 23rem;">
                        <h2 class="display-2 mb-3 pb-3">Sign-Up</h2>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-danger font-weight-bold">* Required Field </p>
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
                                <input pattern="[\w'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,30}"
                                       name="user_first_name"
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
                            <div class="col-6">
                                <p class="text-dark">Enter your birthday<small class="text-danger"> *</small></p>
                            </div>
                            <div class="col-6">
                                <p class="text-dark">Sex<span class="text-danger"> *</span></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <input name="user_dob" type="date" pattern="\d{4}-\d{2}-\d{2}"
                                       value="0000-00-00"
                                       required><br>
                                <small class="text-danger"> [User must be 18+]</small>
                            </div>
                            <script>
                                var maxDate = new Date();
                                maxDate.setFullYear(maxDate.getFullYear() - 18);
                                var formattedMaxDate = maxDate.toISOString().split('T')[0];
                                document.querySelector('input[name="user_dob"]').setAttribute('max', formattedMaxDate);

                                var minDate = new Date();
                                minDate.setFullYear(minDate.getFullYear() - 80);
                                var formattedMinDate = minDate.toISOString().split('T')[0];
                                document.querySelector('input[name="user_dob"]').setAttribute('min', formattedMinDate);
                            </script>


                            <!-- Input Gender  -->
                            <div class="col-6">
                                <input type="radio" id="Male" name="gender" value="Male">
                                <label for="Male" class="text-dark">Male</label>
                                <input type="radio" id="Female" name="gender" value="Female">
                                <label for="Female" class="text-dark">Female</label>
                                <input type="radio" id="Other" name="gender" value="Other">
                                <label for="Other" class="text-dark">Other</label>
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
    </div>
</div>

</body>


</html>




