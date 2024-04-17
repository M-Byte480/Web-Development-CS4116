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
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="section-title">

                <h2>Pub-Club</h2>

            </div>
            <div class="row content">
                <div class="col-lg-6">
                    <p>Pub-Club is a site for real people who enjoy a fresh pint at the end of their day and want to
                        share that joy with others!</p>
                    <ul>
                        <li><i class="mdi--drink"></i>
                            " Chat and Message with people online to organise Real life meet-ups! "
                        </li>
                        <li><i class="mdi--drink"></i>
                            " Match with people who pique your interest based on their go-to drink! "
                        </li>
                        <li><i class="mdi--drink"></i>
                            " Make your profile look sweet as hell to get those clicks! "
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0"
                <p="">Get in the action with over 50+ users and meet your Pint Mate today!<p></p>
                <p>Sign Up now!!</p>
                <a href="../Signup/" class="btn btn-dark">
                    Sign up
                </a>
            </div>
        </div>
    </section>
    <hr>
    <section id="team" class="team align-items-center ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-xs-12">
                    <div class="card border-dark">
                        <img src="../resources/infocards/breny.png" alt="Milan"
                             style="width:100%; height:30vw">
                        <div class="container">
                            <h2>Brendan Quinn</h2>
                            <hr>
                            <p class="title">Designated Driver</p>
                            <p>My name is Brendan, professional Overwatch player</p>
                            <p>breny.test@example.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-12">
                    <div class="card border-dark">
                        <img src="../resources/infocards/kevin.png" alt="Milan"
                             style="width:100%; height:30vw">
                        <div class="container">
                            <h2>Kevin Hough</h2>
                            <hr>
                            <p class="title">CEO of the Slabs</p>
                            <p>My name is Kevin, how are ya now pal? Pints Later?</p>
                            <p>kevin.test@example.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-12">
                    <div class="card border-dark">
                        <img src="../resources/infocards/milan.png" alt="Milan"
                             style="width:100%; height:30vw">
                        <div class="container">
                            <h2>Milan Kovacs</h2>
                            <hr>
                            <p class="title">Supreme Pint Enjoyer</p>
                            <p>My name is Milan and I love coding and Beer</p>
                            <p>Add a little spice to your life</p>
                            <p>milan.test@example.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xs-12">
                    <div class="card border-dark">
                        <img src="../resources/infocards/tadhg.jpg" alt="Milan"
                             style="width:100%; height:30vw">
                        <div class="container">
                            <h2>Tadhg Ryan</h2>
                            <hr>
                            <p class="title">Ladies Man</p>
                            <p>My name is Tadhg you can find me drinking in Stables</p>
                            <p>tadhg.test@example.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<footer id="footer" class="text-center text-lg-start text-white bg-dark">
    <section class="d-flex justify-content-center p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Find us on Social Media!</span>
        </div>
        <div>
            <a href="https://github.com/M-Byte480/Web-Development-CS4116.git" class="me-4 text-reset">
                <i class="fab fa-github"></i>
            </a>
        </div>
    </section>
</footer>

</body>
</html>