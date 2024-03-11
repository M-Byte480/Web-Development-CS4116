<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
<?php require_once(__DIR__."/../NavBar/index.php") ; ?>
<!-- Import Nav Bar -->
<?php

function action_button()
{
    ?>
    <div class="dropdown">
        <div class="mobile-menu-toggle">
            <button class="btn btn-danger dropdown-toggle mobile-toggle-btn btn-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" >Ban</a></li>
                <li><a class="dropdown-item" href="#">Remove</a></li>
                <li><a class="dropdown-item" href="#">Place holder</a></li>
            </ul>
        </div>
    </div>
    <?php
}

function get_userPFP()
{
    ?>
    <img src="./cat.jpeg"
         alt="Profile Picture"
         class="img-fluid rounded-circle"
         style="width: 100px; height: 100px; object-fit: cover;"
    >
    <?php
}

function user_information()
{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h4>User Name || 21</h4>
            </div>
            <div class="col-md-6">Reported: 5 times
            </div>
        </div>
    </div>
    <?php
}

// Query Database
$usersInDb = [];

// Iterate through each user
for ($i = 0; $i < 15; $i++) {
    $usersInDb[] = $i;
}

foreach ($usersInDb as $user => $details) {
    ?>
    <div class="container">
        <div class=" row align-items-center  mt-3 border curve-100 bg-gray">
            <div class="col-2 col-sm-2 col-md-2 p-1">
                <?php get_userPFP() ?>
            </div>
            <div class="col-8 col-sm-8 col-md-8">
                <?php user_information() ?>
            </div>
            <div class="col-2 col-sm-2 col-md-2 text-md-right">
                <?php action_button() ?>
            </div>
        </div>
    </div>
    <?php
}
?>
</body>
</html>
