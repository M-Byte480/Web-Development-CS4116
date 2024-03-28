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
        <a class="navbar-brand" href="../home/index.php">
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
                    <a class="nav-link float-end" href="../profile_page/index.php">
                        <h2 class="collapse" id="collapsibleNavbar">Profile</h2>
                        <i class="bi bi-person-circle"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
