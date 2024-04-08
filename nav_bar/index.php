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

<?php
require_once("../validator_functions.php");
try {
    validate_user_logged_in();
    $user_logged_in = true;
} catch (ValidationException $e) {
    $user_logged_in = false;
}
try {
    validate_user_is_admin();
    $user_is_admin = true;
} catch (ValidationException $e) {
    $user_is_admin = false;
}

?>

<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../home/">
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
            <ul class="navbar-nav float-end">
                <?php
                if ($user_logged_in) {
                    ?>
                    <li class="nav-item p-2">
                        <a class="nav-link float-end" href="../search">
                            <h2 class="collapse" id="collapsibleNavbar">Search</h2>
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="nav-link float-end" href="#">
                            <h2 class="collapse" id="collapsibleNavbar">Messages</h2>
                            <i class="bi bi-envelope"></i>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item p-2 btn-group justify-content-end">
                    <button class="bg-transparent border-0 p-0" type="button"
                            id="profileDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <a class="nav-link float-end">
                            <h2 class="collapse" id="collapsibleNavbar">Profile</h2>
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-md-end position-absolute"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="float-end dropdown-item" href="../profile">
                                <h4>Profile</h4>
                            </a>
                        </li>
                        <?php
                        if ($user_is_admin) {
                            ?>
                            <li>
                                <a class="float-end dropdown-item" href="../admin">
                                    <h4>Admin</h4>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a class="float-end dropdown-item" href="../logout.php">
                                <h4>Logout</h4>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
