<?php

session_start();

require_once(__DIR__ . "/../database/repositories/users.php");

print_r($_POST);

if (isset($_POST['db_username']) && isset($_POST['db_password'])) {

    function validate($data)
    {
        $data = trim($data);

        $data = stripslashes($data);

        $data = htmlspecialchars($data);

        return $data;
    }
}
?>