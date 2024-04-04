<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">


    <title>Document</title>
</head>
<body >

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
                        jsonData['errors'].forEach( elm => {
                            msg += elm;
                        })
                        alert(msg);                    }
                }
            });
        });
    });
</script>


<div class="container">
    <div class="row background-gray">

        <div class="col">
            <h1>SIGNUP</h1>
            <p><span class="error">* required field</span></p>
        </div>

        <div class="col-12">
            <form class="form"  action="signup_backend.php" method="post" id="signup" >

                 <!-- Input Email -->
                 <div class="form-group">
                     <label for="user_email">Email Address</label>
                     <span class="error">*</span>
                     <label for="user_email"></label>
                     <input name="user_email" id="user_email" type="email" class="form-control"  placeholder="Enter email" required>
                    <small id="emailHelp" class="form-text text-muted">Please enter your first name.</small>
                 </div>

                <!-- Input First Name -->
                <div class="form-group">
                    <label for="user_first_name">First Name</label>
                    <span class="error">*</span>
                    <input name="user_first_name" id="user_first_name" type="text" class="form-control" placeholder="Enter your first name" required>
                    <small id="nameHelp" class="form-text text-muted">Please enter your first name.</small>
                </div>

                <!-- Input Second Name -->
                <div class="form-group">
                    <label for="user_second_name">Second Name</label>
                    <span class="error">*</span>
                    <label for="user_second_name"></label><input name="user_second_name" id="user_second_name" type="text" class="form-control" placeholder="Enter your surname"  required>
                    <small id="nameHelp" class="form-text text-muted">Please enter your surname.</small>
                </div>

                <!-- Input Password-->
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <span class="error">*</span>
                    <label for="user_password"></label><input name="user_password" id="user_password" type="password" class="form-control"
                                                              placeholder="Password">
                    <small id="passwordHelp" class="form-text text-muted">Password may not contain special characters.</small>
                </div>

                <!-- Validate Password-->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <span class="error">*</span>
                    <label for="password_confirmation"></label><input name="password_confirmation" id="password_confirmation" type="password" class="form-control"
                                                                      placeholder="Re-enter your password" required>
                    <small id="passwordHelp" class="form-text text-muted">Password may not contain special characters.</small>
                </div>

                <!-- Input Date of Birth -->
                <label class="form-group">
                    <p>Enter your birthday<span class="error"> *</span></p>
                    <input name="user_dob" type="date" pattern="\d{4}-\d{2}-\d{2}"
                           value="2018-07-22" min="1920-01-01" max="2006-04-04"
                           required>
                    <span class="validity"></span>
                </label>


                <!-- Input Gender  -->
                <div class="form-group" >
                    <p>Sex<span class="error"> *</span></p>
                    <input type="radio" id="gender" name="gender" value="Male">
                    <label>Male</label>
                    <input type="radio" id="gender" name="gender" value="Female">
                    <label>Female</label>
                    <input type="radio" id="gender" name="gender" value="Other">
                    <label>Other</label>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>


</html>




