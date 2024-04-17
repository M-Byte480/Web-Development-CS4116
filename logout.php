<?php

setcookie("email", "", time() - (86400 * 15), "/");
setcookie("hashed_password", "", time() - (86400 * 15), "/");

header("location: ./home");