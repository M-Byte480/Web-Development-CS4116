<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="styles.css">
    <!-- Proper + Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <title>Landing Page</title>
</head>
<body>

<?php
require_once("../NavBar/index.php")
?>
    
<div id="landing-carousel" class="carousel slide" data-bs-ride="carousel" data-interval="3000">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item carousel-image bg-img-1 active">
            <!-- <img src="landing1.png" alt="railed" class="d-block w-100" > -->
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
        <div class="carousel-item carousel-image bg-img-2">
            <!-- <img src="landing2.png" alt="mendrink" class="d-block w-100" > -->
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
        <div class="carousel-item carousel-image bg-img-3">
            <!-- <img src="landing3.png" alt="womendrink" class="d-block w-100" > -->
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
    </div>
</div>

</body>
</html>