<?php
function get_profile_card($user)
{
    ?>
    <div class="card bg-dark text-white">
        <img class="card-img" src="<?= '' ?>" alt="Card image">
        <div class="card-img-overlay">
            <h5 class="card-title"> <?= $user['firstname'] ?> </h5>
            <p class="card-text"> <?= '' ?> </p>
        </div>
    </div>
    <?php
}

?>