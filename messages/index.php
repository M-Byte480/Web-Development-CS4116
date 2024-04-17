<!doctype html>
<html lang="en">
<head>
    <?php require_once("../imports.php"); ?>
    <title>Messaging</title>
</head>
<body>
<?php require_once("../nav_bar/index.php") ?>
<div class="container">
    <div class="row">
        <div class="col-4 col-12">
            <div class="card messages p-3 m-0  bd-example m-0 ">
                <div id="connections" class="connection-list">
                    <ul class="list-unstyled list-group-flush chl mt-2 mb-0">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <img src="../resources/pfps/Screenshot_2023-07-31_203438.png" alt="breny"
                                 class="rounded-circle">
                            <div class="info">
                                <div class="name">Brendan Quinn</div>
                                <div class="lmessage">" shup will ya "</div>
                            </div>
                            <span class="badge text-bg-primary rounded-pill">12</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <img src="../resources/pfps/Screenshot_2023-07-31_203438.png" alt="breny"
                                 class="rounded-circle">
                            <div class="info">
                                <div class="name">Brendan Quinn</div>
                                <div class="lmessage">" shup will ya "</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="chat-box">
                <div class="chat-head clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a>
                                <img src="../resources/pfps/Screenshot_2023-07-31_203438.png" alt="breny"
                                     class="rounded-circle">
                            </a>
                            <div class="cinfo">
                                <h4 class="m-b-0">Breny</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <svg width="12" height="14" fill="currentColor" class="bi bi-three-dots-vertical"
                                     viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-light bg-light">
                                <li><a class="dropdown-item text-warning" href="#">Report</a></li>
                                <li>
                                    <hr class="dropdown-divider border-top border-secondary">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#">Delete chat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

