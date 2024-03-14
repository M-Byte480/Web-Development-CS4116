<?php

function getUserById($con, $id)
{
    $sql = "SELECT * FROM user WHERE id = '{$id}'" ;
    $result = mysqli_query($con,$sql);

    return $result;
}

function getAllUsers($con)
{
    $sql = "SELECT * FROM user" ;
    $result = mysqli_query($con,$sql);

    return $result;
}


?>