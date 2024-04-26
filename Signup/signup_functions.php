<?php
require_once(__DIR__ . '/../validator_functions.php');
function validate_post_data(): array
{
    $errors = [];

    // Email
    validate_email($_POST['user_email'], $errors);

    // Firstname
    if (!isset($_POST['user_first_name'])) {
        $errors[] = "First name is empty \r";
    } else {
        validate_name($_POST['user_first_name'], $errors, 'Firstname');
    }

    // Second name
    if (!isset($_POST['user_second_name'])) {
        $errors[] = "Surname is empty \r";
    } else {
        validate_name($_POST['user_second_name'], $errors, 'Surname');
    }

    // Password
    if (!isset($_POST['user_password'])) {
        $errors[] = "Password field is empty \r";
    } else {
        validate_password($_POST['user_password'], $errors);
    }

    // Confirm Password
    if ($_POST["user_password"] !== $_POST["password_confirmation"]) {
        $errors[] = "Passwords must match \r";
    }

    // Gender
    if (!isset($_POST['gender']) || $_POST['gender'] === '') {
        $errors[] = "Gender is not set";
    }

    return $errors;
}

function custom_uuid(): string
{
    $bytes = random_bytes(16);

    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

    // Format the bytes as a UUID
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

function encoder($picture_path): string
{
    $imagedata = file_get_contents($picture_path);
    return base64_encode($imagedata);
}

function set_profile_picture_on_gender($id, $gender): void
{
    $image = "";
    switch ($gender) {
        case 'Male':
            $image = "../resources/search/default_image.jpg";
            break;
        case 'Female':
            $image = "../resources/search/default_female_image.jpg";
            break;
        case 'Other':
            $image = "../resources/search/default_other_image.jpg";
            break;
    }


    update_user_pfp_from_user_ID($id, encoder($image));
}

?>

