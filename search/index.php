<?php
// Validate is user logged in

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="styles.css">
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>PubClub Admin</title>
</head>
<body>
<?php require_once(__DIR__ . '/../NavBar/index.php') ?>

<div class="container">
    <div class="row">

        <div class="col-sm-12 col-md-4 bg-light p-3 border">
            <div class="gender">
                Here is the gender box
            </div>
            <div class="age">
                Here is the age box
            </div>
        </div>
        <div class="col-sm-12 col-md-4 bg-light p-3 border">
            .col-3: width of 25%
        </div>
        <div class=" col-sm-12 col-md-4 bg-light p-3 border">
            <div class="hobbies">
                Here is the hobbies
            </div>
        </div>
    </div>

</div>

</body>
</html>