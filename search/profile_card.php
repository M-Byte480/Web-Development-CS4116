<?php
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");

function get_user_age($user): int
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function get_profile_card(array $user, int $interest_flag): void
{
    ?>
    <div id="<?= $user['id'] ?>" onclick="onCardClicked('<?= $user['id'] ?>')"
         class="bg-dark text-white border border-2 border-dark rounded-4 user_card  m-1">
        <?php

        require_once(__DIR__ . '/../database/repositories/images.php');

        $cover_image = get_user_pfp_from_user_ID($user['id']);

        if ($cover_image == null || strlen($cover_image) < 4) {
            $cover_image = '../resources/search/default_image.jpg';
        } else {
            $cover_image = 'data:image/png;base64,' . $cover_image;
        }
        ?>

        <div class="img-overlay rounded-4"
             style="height: 400px; background-size: cover;
                     background-position: center; background-image: url('<?= $cover_image ?>')">
            <div class="name rounded-4">
                <div class="bottom ">
                    <h5 class=" no-margin user-name"> <?= $user['firstname'] . ' ' . $user['lastname'] . ' ' . get_user_age($user) ?> </h5>
                    <div class=" no-margin no-padding-top">
                        <?php
                        echo $user['beverage'];
                        if ($interest_flag) {
                            echo '<br>' . $user['matching_interests'] . ' matching interests';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>