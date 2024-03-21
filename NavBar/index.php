<style>
    .navbar {
        background-color: #ff8527;
    }
    .nav-brand {
        width: 4rem;
        height: 4rem;
    }
    .nav-link {
        font-size: 2rem;
    }
    a h2 {
        display: inline;
    }
    a i {
        display: inline;
    }
</style>

<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../Home/index.php">
            <img class="nav-brand" src="../resources/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavbar"
                aria-controls="collapsibleNavbar"
                aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item p-2">
                    <a class="nav-link float-end" href="#">
                        <h2 class="collapse" id="collapsibleNavbar">Search</h2>
                        <i class="bi bi-search" ></i>
                    </a>
                </li>
                <li class="nav-item p-2">
                    <a class="nav-link float-end" href="#" >
                        <h2 class="collapse" id="collapsibleNavbar">Messages</h2>
                        <i class="bi bi-envelope"></i>
                    </a>
                </li>
                <li class="nav-item p-2">
                    <a class="nav-link float-end" href="#" >
                        <h2 class="collapse" id="collapsibleNavbar">Profile</h2>
                        <i class="bi bi-person-circle"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--<nav class="navbar navbar-expand-lg bg-light">-->
<!--    <div class="container-fluid">-->
<!--        <a class="navbar-brand" href="#">Navbar</a>-->
<!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">-->
<!--            <span class="navbar-toggler-icon"></span>-->
<!--        </button>-->
<!--        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">-->
<!--            <ul class="navbar-nav me-auto mb-2 mb-lg-0">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link active" aria-current="page" href="#">Home</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#">Link</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link disabled">Disabled</a>-->
<!--                </li>-->
<!--            </ul>-->
<!--            <form class="d-flex" role="search">-->
<!--                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
<!--                <button class="btn btn-outline-success" type="submit">Search</button>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</nav>-->