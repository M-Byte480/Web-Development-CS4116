<?php
// Validate is user logged in
require_once(__DIR__ . '/../validators.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

require_once(__DIR__ . "/../database/repositories/profilePictures.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
    require_once(__DIR__ . "/../css_binding.php");
    ?>
    <title>Discovery</title>

</head>
<body>
<?php require_once(__DIR__ . '/../NavBar/index.php') ?>
<div class="container">
    <div class="row">
        <div class="d-none d-md-block col-md-1">Thumbs Down</div>
        <div class="col-12 col-sm-4">Picture</div>
        <div class="d-none d-md-block col-md-1">Thumbs Up</div>
        <div class="col-12 col-sm-6">Description</div>
    </div>
</div>

</body>
</html>
