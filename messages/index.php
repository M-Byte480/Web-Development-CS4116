<!doctype html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Messaging</title>
</head>
<body class="bg-secondary" style="overflow-y: hidden;">
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

</style>
<script>
    const tabElms = document.querySelectorAll('a[data-bs-toggle="list"]')
    tabElms.forEach(tabElm => {
        tabElm.addEventListener('shown.bs.tab', event => {
            event.target.setAttribute("active"); // newly activated tab
            event.relatedTarget.removeAttribute("active"); // previous active tab
        })
    });
</script>

<div class="row m-0">
    <div class="col-4 p-0 pe-1">
        <!-- Message threads -->
        <div class="list-group list-group-flush px-1 overflow-scroll" id="messageThreads" style="height: 0">
            <?php
            for ($i = 0; $i < 15; $i++) {
                ?>
                <a href="#"
                   class="list-group-item list-group-item-action border-0 bg-secondary p-0 rounded-3 zoom"
                   data-bs-toggle="list">
                    <div class="p-2 m-0">
                        <div class="row p-2 m-0">
                            <div class="col-3 p-0">
                                <img class="img-fluid rounded-3 mx-auto" src="../resources/milanPFP.png"
                                     alt="Profile picture">
                            </div>
                            <div class="col-9 p-0 ps-3 pt-1">
                                <div>
                                    <h5>Kevin</h5>
                                    <i>Hello, are you still awake?</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="col-8 p-0 position-relative">
        <div class="p-2 fs-2">
            <div class="d-inline-flex">
                <b>Kevin</b>
            </div>
            <div class="btn-group float-end">
                <button class="bg-transparent border-0 p-0 float-end" type="button"
                        id="userOptionsDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <a class="nav-link float-end">
                        <i class="bi bi-three-dots-vertical text-white"></i>
                    </a>
                </button>
                <ul class="dropdown-menu dropdown-menu-md-end position-absolute"
                    aria-labelledby="userOptionsDropdown">
                    <li>
                        <a class="float-end dropdown-item" href="#">
                            <h4>Profile</h4>
                        </a>
                    </li>
                    <li>
                        <a class="float-end dropdown-item" href="#">
                            <h4>Report</h4>
                        </a>
                    </li>
                    <li>
                        <a class="float-end dropdown-item" href="#">
                            <h4>Delete Chat</h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row m-0 bg-white rounded-start border border-2 border-end-0"
             style="border-color:#ff8527!important;" id="messageWindow">
            <!-- Messages -->
        </div>
        <div class="m-0 p-3 position-absolute bottom-0 w-100" id="textInput">
            <div class="form p-0">
                <div class="row p-0">
                    <div class="col-10 p-0">
                        <input type="text" class="form-control bg-secondary border-0"
                               placeholder="Start typing...">
                    </div>
                    <div class="col-2 p-0 ps-3">
                        <button class="btn bg-white rounded-3" type="button"
                                style="--bs-bg-opacity: .1;">
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
    let topOfMessageThread = document.getElementById("messageThreads").getBoundingClientRect().top;
    let topOfMessageWindow = document.getElementById("messageWindow").getBoundingClientRect().top;
    let heightOfTextInput = document.getElementById("textInput").getBoundingClientRect().height;

    document.getElementById("messageThreads").style.height = (vh - topOfMessageThread).toString() + "px";
    document.getElementById("messageWindow").style.height = (vh - topOfMessageWindow - heightOfTextInput).toString() + "px";
</script>
</body>
</html>

