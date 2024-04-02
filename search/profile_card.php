<?php

function get_user_age($user): int
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function get_profile_card(array $user, int $interest_flag): void
{
    ?>
    <script>
        function onCardClicked(user_id) {
            // Open page with get request
            let getRequest = "?user_id=" + user_id;
            window.open("view_profile.php" + getRequest, "_blank");
        }
    </script>
    
    <div onclick="onCardClicked('<?= $user['id'] ?>')"
         class="bg-dark text-white m-1 my-card border border-2 border-dark rounded-4">
        <?php

        require_once(__DIR__ . '/../database/repositories/images.php');

        $cover_image = get_images_by_user_id($user['id']);

        if (sizeof($cover_image) < 1 || strlen($cover_image[0]['image']) < 4) {
            $cover_image = 'default_image.jpg';
        } else {
            $cover_image = $cover_image[0]['image'];
        }
        ?>

        <div class="img-overlay no-mouse-hover rounded-4"
             style="height: 400px; background-size: cover;
                     background-position: center; background-image: url('<?php echo $cover_image; ?>')">
            <div class="name rounded-4">
                <div class="bottom ">
                    <h5 class=" no-margin "> <?= $user['firstname'] . ' ' . get_user_age($user) ?> </h5>
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