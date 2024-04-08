<?php

session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['hashed_password']))
    unset($_COOKIE['hashed_password']);

if (isset($_COOKIE['email']))
    unset($_COOKIE['email']);

unset($_COOKIE);

header("location: ./home");