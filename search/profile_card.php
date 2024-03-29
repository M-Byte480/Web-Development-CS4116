<?php

function get_user_age($user): int
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function get_profile_card($user): void
{
    ?>
    <div class="card bg-dark text-white m-3" style="height:300px;">
        <?php
        // todo: check for pfp existance
        ?>

        <img class="card-img" src="<?= '' ?>" onerror="" alt="Card image">
        <div class="card-img-overlay">
            <div class="name">
                <h5 class=" no-margin "> <?= $user['firstname'] . ' ' . get_user_age($user) ?> </h5>
                <div class=" no-margin no-padding-top"> <?= $user['beverage'] ?> </div>
            </div>
        </div>
    </div>
    <?php
}


?>