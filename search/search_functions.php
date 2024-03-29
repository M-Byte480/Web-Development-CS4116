<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../secrets.settings.php');

function get_user_by_matches($get): bool|mysqli_result|null
{
    // Age
    $min_age = (int)$get['age1'];
    $max_age = (int)$get['age2'];

    if ($min_age > $max_age) {
        $temp = $min_age;
        $min_age = $max_age;
        $max_age = $temp;
    }

    $today = date_create();

    $min_date = clone $today;
    date_sub($min_date, date_interval_create_from_date_string("{$max_age} years"));
    $max_date = clone $today;
    date_sub($max_date, date_interval_create_from_date_string("{$min_age} years"));

    $min_date = $min_date->format('Y-m-d');
    $max_date = $max_date->format('Y-m-d');

    $query = "SELECT u.id, u.firstName as firstname, 
                u.dateOfBirth, profiles.gender, 
                profiles.seeking, profiles.description, 
                COUNT(u.id) as matching_interests,
                bev.name as beverage, profilepictures.pfp as pfp
                FROM users as u
                JOIN profiles ON u.id = profiles.userId
                JOIN userinterests as ui on ui.userId = u.id 
                JOIN interests as i on i.id = ui.interestId
                JOIN userbeverages as userbev on userbev.userId = u.id
                JOIN beverages as bev on bev.id = userbev.beverageId
                JOIN profilepictures on profilepictures.userId = u.id
                WHERE dateOFBirth >= '{$min_date}' AND 
                dateOfBirth <= '{$max_date}'  
                ";

    if (isset($get['genders'])) {
        $query .= "AND
                gender IN ('" . implode("', '", $get['genders']) . "')
                ";
    }

    if (isset($get['interests'])) {
        $size = sizeof($get['interests']);

        $query .= "
                AND 
                i.name IN ('" . implode("', '", $get['interests']) . "') 
                GROUP BY u.id
                HAVING COUNT(u.id) = $size;";
    }

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result;
}

?>