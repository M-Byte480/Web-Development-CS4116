<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("../imports.php"); ?>
    <!-- Custom CSS-->
    <link rel="stylesheet" href="styles.css">
    <title>Landing Page</title>
</head>

<body>
<script>
    const elmnt = document.getElementById("nav-bar");
    document.documentElement.style.setProperty('--navbar-height', elmnt.offsetHeight + 'px');
</script>
<?php require_once("../nav_bar/index.php") ?>
<div id="landing-carousel" class="carousel slide" data-bs-ride="carousel" data-interval="3000">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#landing-carousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item carousel-image active">
            <img src="../resources/landing1.png" alt="railed" class="d-block">
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
        <div class="carousel-item carousel-image">
            <img src="../resources/landing2.png" alt="mendrink" class="d-block">
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
        <div class="carousel-item carousel-image">
            <img src="../resources/landing3.png" alt="womendrink" class="d-block">
            <div class="carousel-caption">
                <h1>Fancy a Pint?</h1>
            </div>
        </div>
    </div>
    <button type="button" class="buttonModal btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
        Sign up / Log in
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form">
                        <form>
                            <p style="align-content: center"> Welcome! </p>
                            <a class="px-0" href=" ../signup/">
                                <button type="button" class="btn btn-dark">Sign-Up</button>
                            </a>
                            <a class="mx-5" href="../login/">
                                <button type="button" class="btn btn-dark">Log-In</button>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<main>
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>About Us</h2>
            </div>
            <div class="row content">
                <div class="col-lg-6">
                    <p>Impsum Delorum</p>
                    <ul>cool</ul>
                    <ul>so</ul>
                    <ul>im</ul>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0"
                <p>Impsum Delorum</p>
                <ul>
                    <li><i class="mdi--drink"></i>
                        " Ullamco laboris nisi ut aliquip ex ea commodo consequat "
                    </li>
                </ul>

            </div>
        </div>
    </section>
</main>
<footer id="footer">

</footer>

</body>
</html>