<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../secrets.settings.php');

/**
 * @param $get
 * pass the $_GET request directly in here
 *
 * Finds the years difference from today for the two ranges
 *
 * Then joins the user, profiles, user interests and user beverages with their names together
 *
 * Sorts it by how many interests users have, unless there was interest provided in the get request;
 * Then it orders by matching interests. Minimum of 1.
 *
 * The rest of the query is concat for a more restrictive query such as
 * AND beverage AND select from (Male, Female) etc.
 *
 * @return bool|mysqli_result|null
 */
function get_user_by_matches($get): bool|mysqli_result|null
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // Todo: Sanitize the incoming $get attributes

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
                bev.name as beverage
                FROM users as u
                JOIN profiles ON u.id = profiles.userId
                JOIN userinterests as ui on ui.userId = u.id 
                JOIN interests as i on i.id = ui.interestId
                JOIN userbeverages as userbev on userbev.userId = u.id
                JOIN beverages as bev on bev.id = userbev.beverageId
                WHERE dateOFBirth >= '{$min_date}' AND 
                dateOfBirth <= '{$max_date}'  
                ";

    if (isset($get['beverage']) && $get['beverage'] !== 'None') {
        $query .= "AND
                bev.name = '{$get['beverage']}'
                ";
    }

    if (isset($get['genders'])) {
        $query .= "AND
                gender IN ('" . implode("', '", $get['genders']) . "')
                ";
    }

    if (isset($get['interests'])) {
        $query .= "
                AND 
                i.name IN ('" . implode("', '", $get['interests']) . "') 
                ";
    }

    $query .= " GROUP BY u.id ORDER BY matching_interests DESC";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result;
}

?>