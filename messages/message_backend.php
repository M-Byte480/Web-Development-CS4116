<?php
require_once("../database/repositories/chatlogs.php");

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);

if (isset($decoded_json->connectionId, $decoded_json->sentUserId)) {
    $connectionId = $decoded_json->connectionId;
    $sentUserId = $decoded_json->sentUserId;

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
} elseif (isset($decoded_json->sentMessage)) {
    if (isset($decoded_json->sentMessage->connectionId, $decoded_json->sentMessage->userId, $decoded_json->sentMessage->content)) {
        $connectionId = $decoded_json->sentMessage->connectionId;
        $sentUserId = $decoded_json->sentMessage->userId;
        $content = $decoded_json->sentMessage->content;

        add_chatlog($connectionId, $sentUserId, $content);
    }
}
?>