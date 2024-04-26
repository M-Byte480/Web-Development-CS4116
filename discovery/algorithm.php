<?php

function get_best_fit_users()
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = <<<SQL
WITH FilteredUsers AS (SELECT *
                       FROM Users
                                LEFT JOIN Profiles
                                          on Users.id = Profiles.userId
                       WHERE gender in ('Female', 'Male', 'Other')
                         AND dateOfBirth >= '1980-12-12'
                         AND dateOfBirth <= '2020-12-12'
                         AND Users.id NOT IN (SELECT reports.reportedId as reportedUserIdsByQuerriedUser
                                              FROM Reports
                                              WHERE reports.reporterId = '0379359d-b4e4-4d90-aa69-a3527f5d8adf'
                                              GROUP BY reports.reportedId)
                         AND Users.id != 'my-id'
                         AND Users.banned != 1),
     SortedUsers AS (SELECT *
                     FROM (SELECT FilteredUsers.id, COUNT(*) as matchingInterestCount
                           FROM FilteredUsers
                                    LEFt JOIN userinterests ON FilteredUsers.id = userinterests.userId
                                    LEFt JOIN interests ON userinterests.interestId = interests.id
                           WHERE interests.name IN
                                 ('Money', 'Oil', 'Cars', 'Drinking', 'Movies', 'Pool', 'Rugby', 'Soccer', 'Art')
                           GROUP BY FilteredUsers.id
                           ORDER BY matchingInterestCount DESC) AS MatchingInterestsUsers
                     UNION
                     (SELECT FilteredUsers.id AS exclude_id, 0 as matchingInterestCount
                      FROM FilteredUsers
                               LEFt JOIN userinterests ON FilteredUsers.id = userinterests.userId
                               LEFt JOIN interests ON userinterests.interestId = interests.id
                      WHERE interests.name IN
                            ('Money', 'Oil', 'Cars', 'Drinking', 'Movies', 'Pool', 'Rugby', 'Soccer',
                             'Art'))
     ),
     PreservedOrder AS (SELECT *, ROW_NUMBER() OVER () AS original_order
                        FROM SortedUsers)


SELECT *, PreservedOrder.matchingInterestCount
FROM PreservedOrder
         LEFT JOIN Users ON Users.id = PreservedOrder.id
         LEFT JOIN UserBeverages ON PreservedOrder.id = UserBeverages.userId
         LEFT JOIN Beverages ON UserBeverages.beverageId = Beverages.id
ORDER BY CASE
             WHEN Beverages.name = 'Guinness' THEN PreservedOrder.matchingInterestCount
             ELSE 0
             END DESC;
SQL;

    $result = mysqli_query($con, $query);
    mysqli_close($con);


    return $result;

}