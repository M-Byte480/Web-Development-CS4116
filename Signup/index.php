<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Signup</title>
</head>
<body class>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signup').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'signup_backend.php',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    var jsonData = JSON.parse(response);
                    if (jsonData.success === 1) {
                        window.location.href = "../Home/";
                    } else {
                        let msg = "";
                        jsonData['errors'].forEach(elm => {
                            msg += elm;
                        })
                        alert(msg);
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
            ">* required field '\n'</p>
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
                        <small class="text-danger">[Email must follow xxx@xxx.xxx Format]</small>
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
                        <input name="user_first_name" id="user_first_name" type="text" class="form-control"
                               placeholder="Enter your first name" required>
                        <small class="text-danger">[First name must follow a-z/A-Z Format]</small>
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
                        <input name="user_second_name"
                               id="user_second_name"
                               type="text" class="form-control"
                               placeholder="Enter your surname" required>
                        <small class="text-danger">[Surname must follow a-z/A-Z Format]</small>
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
                               placeholder="Password">
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
                               placeholder="Re-enter your password" required>
                        <small class="text-danger">[Passwords must match]</small>
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
                               value="2006-04-04" min="1920-01-01" max="2006-04-04"
                               required><br>
                        <small class="text-danger"> [User must be 18+]</small>

                    </div>

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




