<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="homestyles.css">
    <title>Document</title>
</head>
<body>
    
<div class = "container-fluid p-2 bg-primary text-black text-center">
    <h1> PubClub </h1>
</div>

<div id="landing-carousel" class="carousel slide" data-bs-ride="carousel" data-interval="3000">

    <div class = "carousel-indicators">
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
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


<?php

setcookie('user_id', '408b4d33-e211-11ee-ac66-80fa5b8f4456', time() + 60 * 60 * 24 * 7, '/');
?>
</body>
</html>