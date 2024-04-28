<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_admin.php');
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");

?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <meta http-equiv="content-type" content="no-cache, must-revalidate">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="styles.css">
    <title>PubClub Admin</title>
</head>
<body>

<script>


    /*
    Global Variable for the button clicked
     */
    var actionButtonState = '';

    function updateAction(newState) {
        actionButtonState = newState;
    }

    /*
    Displays Toast
     */
    function getToast(msg) {
        return `<div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Ban Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${msg}
                </div>
            </div>
        </div>`
    }

    /*
        Fetches the ban modal content based on the UUID
     */
    function fetchBanUser(user_id) {
        $.ajax({
            type: "POST",
            url: 'admin_backend.php',
            data: {
                'id': user_id,
                'action': 'get-ban-details'
            },
            success: function (response) {
                $('.ban-modal').html(response);
            }
        });
    }

    /*
    Fetches the user profile actions modal content based on the UUID
    */
    function fetchUserActions(user_id) {
        $.ajax({
            type: "POST",
            url: 'admin_backend.php',
            data: {
                'id': user_id,
                'action': 'get-user-actions'
            },
            success: function (response) {
                $('#user-modal').html(response);
            }
        });
    }

    /*
    Fetches the ban History modal content based on the UUID
    */
    function fetchBanHistory(user_id) {
        $.ajax({
            type: "POST",
            url: 'admin_backend.php',
            data: {
                'id': user_id,
                'action': 'get-ban-history'
            },
            success: function (response) {
                $('#history-modal').html(response);
            }
        });
    }

    /*
    Fetches the report history modal content based on the UUID
    */
    function fetchReportLogs(user_id) {
        $.ajax({
            type: "POST",
            url: 'admin_backend.php',
            data: {
                'id': user_id,
                'action': 'get-report-history'
            },
            success: function (response) {
                $('#history-modal').html(response);
            }
        });
    }


    function changeRowColour(id, colour) {

        var element = document.getElementById(`row-${id}`);

        if (colour === 'unbanned') {
            element.classList.add('bg-gray');
            element.classList.remove('bg-red');
        } else {
            element.classList.remove('bg-gray');
            element.classList.add('bg-red');
        }

    }

    // Ban, and Unban AJAX
    $(document)
        .ready(function () { // On DOM ready
            $('#banForm').submit(function (e) {
                e.preventDefault(); // Overrides the default Form Submission

                var button1 = document.getElementById('permanent-ban');
                var button2 = document.getElementById('temporary-ban');
                var button3 = document.getElementById('unban');

                button1.disabled = true;
                button2.disabled = true;
                button3.disabled = true;

                $.ajax({ // Send this asynchronously
                    type: "POST",
                    url: 'admin_backend.php',
                    data: $(this).serialize() + '&action=' + actionButtonState,
                    success:

                        function (response) {
                            var jsonData = JSON.parse(response);

                            setTimeout(() => {
                                button1.disabled = false;
                                button2.disabled = false;
                                button3.disabled = false;
                            }, 1000);

                            let toastHTML = getToast(jsonData['msg']);
                            $(document.body).append(toastHTML);
                            $('.toast').toast('show');
                            // Check for what the backend returned value is
                            if (jsonData.success == "1") {
                                if (jsonData['msg'].includes("unbanned")) {
                                    changeRowColour(jsonData['user_id'], 'unbanned');
                                } else {
                                    changeRowColour(jsonData['user_id'], 'banned');
                                }
                            }
                        }
                });
            });
        });

    /*
    Ajax to edit profile
 */
    $(document)
        .ready(function () {
            $('#editUserForm').submit(function (e) {

                e.preventDefault();

                var button1 = document.getElementById('remove_pfp');
                var button2 = document.getElementById('remove_all_images');
                var button3 = document.getElementById('remove_bio');

                button1.disabled = true;
                button2.disabled = true;
                button3.disabled = true;

                $.ajax({
                    type: "POST",
                    url: 'admin_backend.php',
                    data: $(this).serialize() + '&action=' + actionButtonState,
                    success: function (response) {
                        var jsonData = JSON.parse(response);

                        setTimeout(() => {
                            button1.disabled = false;
                            button2.disabled = false;
                            button3.disabled = false;
                        }, 1000);

                        if (jsonData.success == "1") {
                            let toastHTML = getToast(jsonData['msg']);
                            $(document.body).append(toastHTML);
                            $('.toast').toast('show');

                        } else {
                            let toastHTML = getToast('There was an issue doing that');
                            $(document.body).append(toastHTML);
                            $('.toast').toast('show');
                        }
                    }
                });
            });
        });

    // DELETE USER AJAX
    $(document).ready(function () { // On DOM ready
        $('#removeForm').submit(function (e) {
            e.preventDefault(); // Overrides the default Form Submission

            $.ajax({ // Send this asynchronously
                type: "POST",
                url: 'admin_backend.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // Check for what the backend returned value is
                    if (jsonData.success == "1") {
                        let toastHTML = getToast("User Successfully Been Removed!");
                        $(document.body).append(toastHTML);
                        $('.toast').toast('show');
                        $(document).getElementById('')
                    } else {
                        let toastHTML = getToast("Failed to remove user!");
                        $(document.body).append(toastHTML);
                        $('.toast').toast('show');
                    }
                }
            });
        });
    });


</script>

<?php

// Import navigation bar
require_once(__DIR__ . "/../nav_bar/index.php");
?>

<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="search-bar-container m-2">
                <div class="form-floating m-2">
                    <input id="searchBar" size=50 type="text" class="form-control search-bar"
                           placeholder="Search Users">
                    <label for="searchBar">Search Users</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-3 pb-3">
    <div class="row mb-3 pb-3" id="users_container">
    </div>
</div>

<form method="post" action="admin_backend.php" class="banForm" id="banForm">
    <!-- BAN MODAL -->
    <div class="modal fade" tabindex="-1" aria-labelledby="banModalLabel" id="banModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="banModalLabel">Ban Menu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body ban-modal">

                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" value="permanent" class="btn btn-primary" id="permanent-ban"
                            onclick="updateAction('permanent')"

                    > Permanently Ban
                    </button>
                    <button type="submit" name="submit" value="temporary" class="btn btn-primary" id="temporary-ban"
                            onclick="updateAction('temporary')"

                    >Temporary Ban
                    </button>
                    <button type="submit" name="submit" value="unban" class="btn btn-primary" id="unban"
                            onclick="updateAction('unban')"

                    >Unban user
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!--Edit user Modal -->
<form method="post" action="admin_backend.php" class="editUserForm" id="editUserForm">
    <div class="modal fade" tabindex="-1" aria-labelledby="editUserModalLabel" id="editUserModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editUserModalLabel">Edit User Menu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body user-modal" id="user-modal">

                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" value="remove_pfp" class="btn btn-primary" id="remove_pfp"
                            onclick="updateAction('remove_pfp')">
                        Remove PFP
                    </button>
                    <button type="submit" name="submit" value="remove_all_images" class="btn btn-primary"
                            id="remove_all_images"
                            onclick="updateAction('remove_all_images')">
                        Remove all pictures
                    </button>
                    <button type="submit" name="submit" value="remove_bio" class="btn btn-primary" id="remove_bio"
                            onclick="updateAction('remove_bio')">
                        Remove user Bio
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" tabindex="-1" aria-labelledby="historyId" id="viewHistoryModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="historyId">Logs</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body history-modal" id="history-modal">

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let stop_displaying_users = false;
        let update_at_end = false;
        let row_num = 0;

        function display_users(resetDiv) {
            if (stop_displaying_users) {
                update_at_end = true;
                return;
            }
            stop_displaying_users = true;
            update_at_end = false;
            setTimeout(() => {
                stop_displaying_users = false;
                if (update_at_end)
                    display_users(resetDiv);
            }, 500);
            let searchText = $("#searchBar").val().toLowerCase().trim();
            let postData = {
                "searchText": searchText,
                "row_number": row_num
            };
            $.ajax({
                type: "POST",
                url: "admin_backend.php",
                data: {
                    "action": "get-users",
                    json: JSON.stringify(postData)
                },
                success:
                    function (response) {
                        if (resetDiv)
                            document.getElementById("users_container").innerHTML = "";
                        document.getElementById("users_container").innerHTML += response;
                    },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }

        display_users(false);
        $('#searchBar').on('input', function () {
            row_num = 0;
            display_users(true);
        });

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() === $(document).height()) {
                row_num += 8;
                display_users(false);
            }
        });
    });

    $(document).ready(function () {
        $('#removeForm').submit(function (e) {
            e.preventDefault();
        });
    });

    function deleteUser(userId) {
        if (confirm('Are you sure? This action cannot be undone')) {
            $.ajax({ // Send this asynchronously
                type: "POST",
                url: 'admin_backend.php',
                data: $(`#removeForm-${userId}`).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // Check for what the backend returned value is
                    if (jsonData.success == "1") {
                        let toastHTML = getToast("User Successfully Been Deleted!");
                        $(document.body).append(toastHTML);
                        $('.toast').toast('show');
                        $(document).getElementById('')
                    } else {
                        let toastHTML = getToast("Failed to delete user!");
                        $(document.body).append(toastHTML);
                        $('.toast').toast('show');
                    }
                }
            });
            document.getElementById(userId).remove();
            return true;
        } else {
            return false;
        }
    }
</script>
</body>
</html>
