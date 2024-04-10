<?php
function get_user_name($user)
{
    return $user['firstName'] . ' ' . $user['lastName'];
}

/**
 * @throws Exception
 */
function get_user_age($user): int
{
    $dob = new DateTime($user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    return $diff->y;
}

function ban_user($user_id): void
{
    echo 'user banned';
}

function set_ban_state($id, $state)
{

}

function ban_user_functionality($user): void
{
    ?>

    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Banning:</label>
        <input class="form-control" type="text"
               value="<?= $user['firstName'] . " " . $user['lastName'] ?>"
               aria-label="Disabled input example" disabled readonly>

    </div>
    <div class="mb-3">
        <label for="banReasonTextBox" class="form-label">Ban Reason:</label>
        <textarea class="form-control" id="banReasonTextBox" rows="3"></textarea>
    </div>
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
    <input type="hidden" name="banned_by_email" value="<?= $_COOKIE['email'] ?>">
    <input type="hidden" name="action" value="ban">
    <label class="form-group" for="banExpirationDate">
        Temporary ban expiration:
    </label>
    <br>
    <input id="banExpirationDate" type="date" name="unbanDate" pattern="\d{4}-\d{2}-\d{2}"/>
    <i>Only enter expiration if its not permanent</i>
    <span class="validity"></span>

    <?php
}

function get_user_actions($user): void
{
    ?>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Banning:</label>
        <input class="form-control" type="text"
               value="<?= $user['firstName'] . " " . $user['lastName'] ?>"
               aria-label="Disabled input example" disabled readonly>

    </div>
    <?php
}

?>


