<?php

require_once(__DIR__ . '/profile_card.php');
require_once(__DIR__ . '/search_functions.php');
require_once(__DIR__ . '/../database/repositories/users.php');

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json, true);

if (isset($decoded_json["name"], $decoded_json["interestFlag"], $decoded_json["getRequest"])) {
    $name = $decoded_json["name"];
    $interestFlag = !$decoded_json["interestFlag"];
    $request = $decoded_json["getRequest"];
    if (isset($decoded_json["row_num"])) {
        $row_num = $decoded_json["row_num"];
    } else {
        $row_num = 0;
    }

    $searched_profiles = get_user_by_matches($request, $name, $row_num);
    $rows = [];
    try {
        while ($row = mysqli_fetch_assoc($searched_profiles)) {
            $rows[] = $row;
        }
    } catch (TypeError $e) {
        return;
    }

    foreach ($rows as $row) {
        ?>
        <div class="col-12 col-md-3 user_card profiles my-card">
            <?php get_profile_card($row, $interestFlag) ?>
        </div>
        <?php
    }
}
?>