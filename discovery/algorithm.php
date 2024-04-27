<?php

function get_best_fit_users($user)
{
    require_once(__DIR__ . '/../database/repositories/profiles.php');
    require_once(__DIR__ . '/../database/repositories/beverages.php');
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $user_id = $user['id'];
    $user_profile = get_user_profile_for_discovery($user_id);

    $user_gender = $user_profile['gender'];
    $user_seeking = $user_profile['seeking'];
    $interests = get_user_interests($user_id);
    $user_interests = "'" . implode("', '", $interests) . "'";

    $user_bev = get_users_beverage_from_user_ID($user_id);

    $query = <<<SQL
WITH DislikedUserIDs as (SELECT Dislikes.dislikedUser as ID
                         FROM Users
                                  LEFT JOIN Dislikes ON Users.id = Dislikes.userId
                         WHERE Dislikes.userId = '{$user_id}'),

     LikedUserIDs as (SELECT Likes.likedUser as ID
                      FROM Users
                               LEFT JOIN Likes ON Users.id = Likes.userId
                      WHERE Likes.userId = '{$user_id}'),

     ReportedUsers as (SELECT Reports.reportedId as ID
                       FROM Reports
                       WHERE Reports.reporterId = '{$user_id}'
                       GROUP BY Reports.reportedId),

     FilteredUsers AS (SELECT DISTINCT *
                       FROM Users
                                LEFT JOIN Profiles
                                          on Users.id = Profiles.userId
                       WHERE gender = '{$user_seeking}'
                         AND dateOfBirth >= '1980-12-12'
                         AND dateOfBirth <= '2020-12-12'
                         AND Users.id NOT IN (SELECT ID
                                              FROM ReportedUsers
                                              UNION
                                              SELECT ID
                                              FROM LikedUserIDs
                                              UNION
                                              SELECT ID
                                              FROM DislikedUserIDs)
                         AND Users.id != '{$user_id}'
                         AND Users.banned != 1),

     SortedUsers AS (SELECT *
                     FROM (SELECT FilteredUsers.id, COUNT(*) as matchingInterestCount
                           FROM FilteredUsers
                                    LEFt JOIN UserInterests ON FilteredUsers.id = UserInterests.userId
                                    LEFt JOIN Interests ON UserInterests.interestId = Interests.id
                           WHERE Interests.name IN
                                 ({$user_interests})
                           GROUP BY FilteredUsers.id
                           HAVING COUNT(*) != 0
                           ORDER BY matchingInterestCount DESC) AS MatchingInterestsUsers
                     UNION
                     (SELECT FilteredUsers.id AS exclude_id, 0 as matchingInterestCount
                      FROM FilteredUsers
                               LEFt JOIN UserInterests ON FilteredUsers.id = UserInterests.userId
                               LEFt JOIN Interests ON UserInterests.interestId = Interests.id
                      WHERE Interests.name NOT IN
                            ({$user_interests}))),
     PreservedOrder AS (SELECT *, ROW_NUMBER() OVER () AS original_order
                        FROM SortedUsers)

SELECT *, PreservedOrder.matchingInterestCount, Profiles.gender, beverages.name as favouriteBeverage
FROM PreservedOrder
         LEFT JOIN Users ON Users.id = PreservedOrder.id
         LEFT JOIN (SELECT DISTINCT UserBeverages.userId, Beverages.name
                    FROM UserBeverages
                             LEFT JOIN Beverages ON UserBeverages.beverageId = Beverages.id) AS beverages
                   ON Users.id = beverages.userId
         LEFT JOIN Profiles ON Users.id = Profiles.userId
WHERE Profiles.seeking = '{$user_gender}' 
ORDER BY CASE
             WHEN favouriteBeverage = '{$user_bev}' THEN PreservedOrder.matchingInterestCount
             ELSE 0
             END DESC,
         CASE
             WHEN favouriteBeverage = '{$user_bev}' THEN original_order
             ELSE PreservedOrder.matchingInterestCount
             END DESC;
SQL;

    $result = mysqli_query($con, $query);
    mysqli_close($con);


    return $result;

}