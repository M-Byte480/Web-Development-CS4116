<?php
require_once ("validator_functions.php");

try{
    validate_user_is_banned();
}catch (ValidationException $e){
    header("Location: ../ban");
    exit();
}