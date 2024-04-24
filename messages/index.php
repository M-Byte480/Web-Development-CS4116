<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../database/repositories/connections.php');

$userId = (string)get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];

$connections = array();
function display_message_thread(): void
{
    global $userId, $connections;
    $connections = get_all_connections_from_userId($userId);

    foreach ($connections as $connection) {
        ?>
        <a href="#"
           class="list-group-item list-group-item-action border-0 bg-secondary p-0 rounded-3 zoom"
           data-bs-toggle="list" data-user_id="<?= $connection['userId'] ?>"
           data-connection_id="<?= $connection['connectionId'] ?>">
            <div class="p-2 m-0">
                <div class="row p-2 m-0">
                    <div class="col-3 p-0">
                        <div class="ratio ratio-1x1">
                            <img class="img-fluid object-fit-cover rounded-top-3"
                                 src="data:image/png;base64,<?= $connection["pfp"] ?>"
                                 alt="Profile picture">
                        </div>
                    </div>
                    <div class="col-9 p-0 ps-3 pt-1">
                        <div>
                            <h5 id="listgroup-name"><?= $connection["firstname"] . " " . $connection["lastname"] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Messaging</title>
</head>
<body class="bg-secondary overflow-y-hidden" data-user_id="<?= $userId ?>">
<?php require_once("../nav_bar/index.php") ?>

<style>

    .zoom {
        transition: transform .4s;
    }

    .zoom:hover {
        transform: scale(1.02);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .form-control:focus {
        outline: none !important;
    }


    .message {
        border-radius: 20px;
        padding: 8px 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        display: inline-block;
    }

    .yours {
        align-items: flex-start;
    }

    .yours .message {
        margin-right: 25%;
        background-color: #EEE;
        position: relative;
    }

    .yours .message.last:before {
        content: "";
        position: absolute;
        z-index: 0;
        bottom: 0;
        left: -7px;
        height: 20px;
        width: 20px;
        background: #EEE;
        border-bottom-right-radius: 15px;
    }

    .yours .message.last:after {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: 0;
        left: -10px;
        width: 10px;
        height: 20px;
        background: white;
        border-bottom-right-radius: 10px;
    }

    .mine {
        align-items: flex-end;
    }

    .mine .message {
        color: white;
        margin-left: 25%;
        background: rgb(0, 120, 254);
        position: relative;
    }

    .mine .message.last:before {
        content: "";
        position: absolute;
        z-index: 0;
        bottom: 0;
        right: -8px;
        height: 20px;
        width: 20px;
        background: rgb(0, 120, 254);
        border-bottom-left-radius: 15px;
    }

    .mine .message.last:after {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: 0;
        right: -10px;
        width: 10px;
        height: 20px;
        background: white;
        border-bottom-left-radius: 10px;
    }

    .textViewBorder {
        border: #ff8527 solid 0.2rem;
        border-right: 0;
    }

    @media screen and (max-width: 767.98px) {
        .textViewBorder {
            border-right: #ff8527 solid 0.2rem;
        }
    }

</style>

<div class="row m-0" id="topLevelRow">
    <div class="col-md-4 p-0 col-sm-12" id="topLevelMessageThread">
        <!-- Message threads -->
        <div class="list-group list-group-flush overflow-y-auto overflow-x-hidden" id="messageThreads"
             style="height: 0">
            <?php display_message_thread(); ?>
        </div>
    </div>
    <div class="col-md-8 col-sm-12 p-0 position-relative" id="topLevelMessageView">
        <div class="fs-2 p-2 d-flex justify-content-between align-items-center">
            <button class="btn" style="font-size:2rem" type="button"
                    onclick="backButtonPressed()" id="backButton">
                <i class="bi bi-arrow-90deg-left text-white"></i>
            </button>
            <b id="thread_title">Select Thread</b>
            <div class="btn-group float-end">
                <button class="bg-transparent border-0 p-0 float-end align-middle" type="button"
                        id="userOptionsDropdown" disabled
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <a class="nav-link float-end">
                        <i class="bi bi-three-dots-vertical text-white"></i>
                    </a>
                </button>
                <ul class="dropdown-menu dropdown-menu-md-end position-absolute"
                    aria-labelledby="userOptionsDropdown">
                    <li>
                        <a class="float-end dropdown-item" href="" id="buttonToUsersProfile">
                            <h4>Profile</h4>
                        </a>
                    </li>
                    <li>
                        <button class="float-end dropdown-item" onclick="sendReport()">
                            <h4>Report</h4>
                        </button>
                    </li>
                    <li>
                        <button class="float-end dropdown-item" onclick="unmatchUsers()">
                            <h4>Unmatch</h4>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row w-100 m-0 bg-light rounded-start overflow-y-auto d-flex flex-column-reverse textViewBorder"
             style="border-color:#ff8527!important;" id="messageWindow">
            <div class="d-flex flex-column p-3" id="message_view">
            </div>
        </div>
        <div class="m-0 p-3 position-absolute bottom-0 w-100" id="textInput">
            <div class="row p-0">
                <form class="d-flex" id="sendMessageForm">
                    <div class="col-10 p-0">
                        <input type="text" class="form-control bg-secondary border-0" disabled
                               placeholder="Start typing..." id="sendMessageInput">
                    </div>
                    <div class="col-2 p-0 ps-3">
                        <button class="btn bg-white rounded-3" type="submit" id="sendMessageButton" disabled
                                style="--bs-bg-opacity: .1;">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function initiateWindow() {
        let vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
        let topOfMessageThread = document.getElementById("messageThreads").getBoundingClientRect().top;
        let topOfMessageWindow = document.getElementById("messageWindow").getBoundingClientRect().top;
        let heightOfTextInput = document.getElementById("textInput").getBoundingClientRect().height;
        let topLevelNavBarHeight = document.getElementById("topLevelNavBar").getBoundingClientRect().height;

        document.getElementById("messageThreads").style.height = (vh - topOfMessageThread).toString() + "px";
        document.getElementById("messageWindow").style.height = (vh - topOfMessageWindow - heightOfTextInput).toString() + "px";
        document.getElementById("topLevelRow").style.height = (vh - topLevelNavBarHeight).toString() + "px";

        if (window.matchMedia("(max-width: 767.98px)").matches) {
            document.getElementById("backButton").classList.add("d-flex");
            document.getElementById("backButton").classList.remove("d-none");
        } else {
            document.getElementById("backButton").classList.add("d-none");
            document.getElementById("backButton").classList.remove("d-flex");
        }
    }

    function backButtonPressed() {
        document.getElementById("topLevelMessageThread").classList.add("d-block");
        document.getElementById("topLevelMessageThread").classList.remove("d-none");
        document.querySelector('a[data-bs-toggle="list"].active').classList.remove("active");
    }

    function sendButtonClicked() {
        if (document.querySelector('#sendMessageInput').value === "")
            return
        let postData = {
            "sentMessage": {
                "connectionId": document.querySelector('a[data-bs-toggle="list"].active').dataset.connection_id,
                "userId": document.querySelector('body').dataset.user_id,
                "content": document.querySelector('#sendMessageInput').value
            }
        };
        $.ajax({
            type: "POST",
            url: "message_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
                document.querySelector('#sendMessageInput').value = "";
                updateMessageView();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    function updateMessageView() {
        if (document.querySelector('a[data-bs-toggle="list"].active') == null)
            return;
        let postData = {
            "getMessages": {
                "connectionId": document.querySelector('a[data-bs-toggle="list"].active').dataset.connection_id,
                "sentUserId": document.querySelector('a[data-bs-toggle="list"].active').dataset.user_id
            }
        };
        $.ajax({
            type: "POST",
            url: "message_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
                document.getElementById("message_view").innerHTML = "";
                $("#message_view").append(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
        if (document.querySelector('a[data-bs-toggle="list"].active') == null)
            return;
        setTimeout(updateMessageView, 5000);
    }

    function sendReport() {
        let postData = {
            "reportUser": {
                "userId": document.querySelector('a[data-bs-toggle="list"].active').dataset.user_id
            }
        };
        $.ajax({
            type: "POST",
            url: "message_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    function unmatchUsers() {
        let postData = {
            "unmatchUsers": {
                "userId": "<?= $userId ?>",
                "userToUnmatchId": document.querySelector('a[data-bs-toggle="list"].active').dataset.user_id
            }
        };
        $.ajax({
            type: "POST",
            url: "message_backend.php",
            data: {
                json: JSON.stringify(postData)
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    $('document').ready(function () {
        initiateWindow();
        window.addEventListener('resize', initiateWindow);

        $("#sendMessageForm").submit(function (e) {
            e.preventDefault();
            sendButtonClicked();
        });

        const tabElms = document.querySelectorAll('a[data-bs-toggle="list"]');
        tabElms.forEach(tabElm => {
            tabElm.addEventListener('shown.bs.tab', event => {
                // Thread Clicked...
                document.getElementById("thread_title").innerHTML = document.querySelectorAll("#messageThreads .active #listgroup-name")[0].innerHTML;
                document.getElementById("sendMessageInput").removeAttribute("disabled");
                document.getElementById("sendMessageButton").removeAttribute("disabled");
                document.getElementById("userOptionsDropdown").removeAttribute("disabled");
                document.getElementById("buttonToUsersProfile").setAttribute("href", "../profile/?user_id=" +
                    document.querySelector('a[data-bs-toggle="list"].active').dataset.user_id);

                if (window.matchMedia("(max-width: 767.98px)").matches) {
                    document.getElementById("topLevelMessageThread").classList.add("d-none");
                    document.getElementById("topLevelMessageThread").classList.remove("d-block");
                }
                updateMessageView();
            });
        });
    });
</script>
</body>
</html>

