<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body >
<div class="container">
    <div class="row background-gray">
        <div class="col">
            <h1>SIGNUP</h1>
            <p><span class="error">* required field</span></p>
        </div>
        <div class="col-12">
            <form class="form">
                <!-- Input Email -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <span class="error">*</span>
                    <input type="email" class="form-control" id="exampleInputEmail1"
                           aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                        anyone else.</small>
                </div>

                <!-- Input Name -->
                <div class="form-group">
                    <label for="exampleInputName">Full Name</label>
                    <span class="error">*</span>
                    <input type="text" class="form-control" id="exampleInputName"
                           placeholder="Enter your full name">
                    <small id="nameHelp" class="form-text text-muted">Please enter your full name.</small>
                </div>

                <!-- Input Password-->
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <span class="error">*</span>
                    <input type="password" class="form-control" id="exampleInputPassword1"
                           placeholder="Password">
                    <small id="passwordHelp" class="form-text text-muted">Password may not contain special characters.</small>
                </div>
                <!-- Input Date of Birth -->
                <label class="form-group">
                    <p>Enter your birthday<span class="error"> *</span></p>
                    <input type="date" name="day" required pattern="\d{4}-\d{2}-\d{2}"/>
                    <span class="validity"></span>
                </label>
                <!-- Input  -->
                <div class="form-group">
                    <p>Sex<span class="error"> *</span></p>
                    <input type="radio" id="male" name="gender" value="Male">
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="Other">
                    <label for="other">Other</label>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

