<?php
function validateAdmin($id)
{
    global $con;
    $retrieved_user = getUserById($con, $id);

    if(array_key_exists('admin', $retrieved_user)){
        if($retrieved_user['admin'] === 1){
            return true;
        }
    }
    return false;
}

// Validation

if(!isset($_COOKIE['email']) || !isset($_COOKIE['password'])){
    header("Location: ../login/index.php");
    exit();
}

$user = getUserById($_COOKIE['user_id']);

if(validateAdmin($user) != 1){
    echo 'Unauthorised';
    exit();
}



?>