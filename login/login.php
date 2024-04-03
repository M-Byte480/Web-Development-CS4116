<?php

session_start();

require_once(__DIR__ . "/../database/repositories/users.php");

print_r($_POST);

if (isset($_POST['email']) && isset($_POST['db_password'])) {

    $email = $_POST['email'];
    $password = $_POST['db_password'];

    if (empty($email) || empty($password)) {
        echo "Please fill in all text fields";
    } else {
        $dquery = "SELECT * FROM Users where email =?";

        $st = $conn->prepare($dquery);
        $st->bind_param("s", $email);
        $st->execute();

        $res = $st->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();

            if (password_verify($password, $row['password'])) {

                $_SESSION['user id'] = $row['id'];
                echo "Login Successful";
            } else {
                echo "Invalid Login";
            }
        } else {
            echo "Invalid Login";
        }
    }
} else {
    echo "Database Query Error";
}

?>



