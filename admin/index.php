<?php
// Validate is user logged in
require_once(__DIR__ . '/../validate_user.php');

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

<?php
// Query Database
$usersInDb = get_all_users();

usort($usersInDb, function ($first, $second) {
    return $first['reportCount'] - $second['reportCount'];
});

?>

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

                            // Check for what the backend returned value is
                            if (jsonData.success == "1") {
                                let toastHTML = getToast(jsonData['msg']);
                                $(document.body).append(toastHTML);
                                $('.toast').toast('show');

                                if (jsonData['msg'].includes("unbanned")) {
                                    changeRowColour(jsonData['user_id'], 'unbanned');
                                } else {
                                    changeRowColour(jsonData['user_id'], 'banned');
                                }

                            } else {
                                let toastHTML = getToast(jsonData['msg']);
                                $(document.body).append(toastHTML);
                                $('.toast').toast('show');
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
                <input id="searchBar" size="35" type="text" class="search-bar" placeholder="Search User..."
                       style="line-height: 30px">
            </div>
        </div>
    </div>
</div>


<?php

function action_button($user): void
{
    ?>
    <div class="dropdown">
        <div class="mobile-menu-toggle">
            <button class="btn <?= $user['banned'] ? 'btn-light' : 'btn-dark' ?> dropdown-toggle mobile-toggle-btn btn-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu p-2">
                <li>
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" value="<?= $user['id'] ?>"
                            data-bs-target="#banModal" onclick="fetchBanUser('<?= $user['id'] ?>')">
                        Ban Options
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                            data-bs-target="#editUserModal" onClick="fetchUserActions('<?= $user['id'] ?>')">
                        User Options
                    </button>
                </li>
                <li>
                    <form id="removeForm-<?= $user['id'] ?>" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="admin_email" value="<?= decrypt_admin_email($_COOKIE['email']) ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="button" class="btn btn-danger m-1" name="removeBtn" id="removeBtn" value="Delete"
                                onclick="deleteUser('<?= $user['id'] ?>')">
                            Delete
                        </button>
                    </form>
                </li>
            </ul>

        </div>
    </div>
    <?php
}

function pfp($user): void
{
    ?>
    <img src="<?= get_user_pfp_from_user_ID($user['id']) ?>"
         alt="Profile Picture"
         class="img-fluid rounded-circle"
         style="width: 100px; height: 100px; object-fit: cover;"
    >
    <?php
}

include_once(__DIR__ . '/admin_functions.php');

function user_information($user): void
{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>
                    <a href="<?= '../profile/' . "?user_id=" . $user['id'] ?>"
                       target="_blank"
                       style="color: inherit;"><?= get_user_name($user) ?></a> <?= get_user_age($user) ?>
                </h4>
            </div>
            <div class="col-md-6">Reports: <?= $user['reportCount'] === null ? 0 : $user['reportCount'] ?>
            </div>
        </div>
    </div>
    <?php
}


foreach ($usersInDb as $user) {
    ?>
    <div class="container list-item" id="<?= $user['id'] ?>">
        <div style="display: none;" class="list-flag">
            <?= get_user_name($user) . ' ' . get_user_age($user) ?></div>
        <div style="display: none;" class="list-id"><?= $user['id'] ?></div>
        <div id="<?= 'row-' . $user['id'] ?>"
             class=" row align-items-center height-100px mt-3 border curve-100 <?= $user['banned'] ? 'bg-red' : 'bg-gray' ?>">
            <div class="col-2 col-sm-2 col-md-2 p-1 width-100px">
                <?php pfp($user) ?>
            </div>
            <div class="col-6 col-sm-8 col-md-8">
                <?php user_information($user) ?>
            </div>
            <div class="col-2 col-sm-2 col-md-2 text-md-right">
                <?php action_button($user) ?>
            </div>
        </div>
    </div>


    <?php
}
?>
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

<script>

    // Search bar filer
    $(document).ready(function () {
        $('#searchBar').on('input', function () {
            let searchText = $(this).val().toLowerCase();
            if (searchText.length === 36) {
                $('.list-item').each(function () {
                    var uuid = $(this).find('.list-id').text();
                    if (searchText.includes(uuid)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            } else {
                $('.list-item').each(function () {
                    var userName = $(this).find('.list-flag').text().toLowerCase();
                    if (userName.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
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
