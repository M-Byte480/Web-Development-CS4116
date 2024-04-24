<?php
require_once("../database/repositories/chatlogs.php");
require_once("../database/repositories/users.php");
require_once("../database/repositories/likes.php");
require_once("../database/repositories/dislikes.php");
require_once("../database/repositories/connections.php");

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);
if (isset($decoded_json->getMessages)) {
    if (isset($decoded_json->getMessages->connectionId, $decoded_json->getMessages->sentUserId)) {
        $connectionId = $decoded_json->getMessages->connectionId;
        $sentUserId = $decoded_json->getMessages->sentUserId;

        $chatlogs = get_all_chatlogs_from_connectionId($connectionId);

        foreach ($chatlogs as $chatlog) {
            if ($chatlog['userSent']) {
                ?>
                <div class="d-flex flex-column mt-3 <?= ($chatlog['userSent'] == $sentUserId) ? "yours" : "mine" ?>">
                    <div class="message last">
                        <div>
                            <?= $chatlog['content'] ?>
                        </div>
                        <small class="float-end text-body-secondary">
                            <?php
                            $date = strtotime($chatlog['time']);
                            echo(date("F j, Y g:i a", $date));
                            ?>
                        </small>
                    </div>
                </div>
                <?php
            }
        }
    }
} elseif (isset($decoded_json->sentMessage)) {
    if (isset($decoded_json->sentMessage->connectionId, $decoded_json->sentMessage->userId, $decoded_json->sentMessage->content)) {
        $connectionId = $decoded_json->sentMessage->connectionId;
        $sentUserId = $decoded_json->sentMessage->userId;
        $content = $decoded_json->sentMessage->content;

        add_chatlog($connectionId, $sentUserId, $content);
    }
} elseif (isset($decoded_json->reportUser)) {
    if (isset($decoded_json->reportUser->userId)) {
        $userId = $decoded_json->reportUser->userId;
        increment_report_count($userId);
    }
} elseif (isset($decoded_json->unmatchUsers)) {
    if (isset($decoded_json->unmatchUsers->userId, $decoded_json->unmatchUsers->userId)) {
        $userId = $decoded_json->unmatchUsers->userId;
        $userToUnmatchId = $decoded_json->unmatchUsers->userToUnmatchId;
        delete_like_by_user_ids($userId, $userToUnmatchId);
        delete_like_by_user_ids($userToUnmatchId, $userId);
        add_dislike_by_user_ids($userId, $userToUnmatchId);
        delete_connection_from_user_ids($userId, $userToUnmatchId);
    }
}
?>