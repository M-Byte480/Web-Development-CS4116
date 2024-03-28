<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Landing Page</title>
</head>
<body>
<?php require_once("../NavBar/index.php") ?>
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

</body>
</html>