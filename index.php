<?php

session_start();
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require("vendor/autoload.php");

// Instantiate F3
$f3 = Base::instance();

// Defining a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//TO PERSONAL INFO PAGE
$f3->route('GET /personal', function () {
    $view = new Template();
    echo $view->render('views/personal_info.html');
});

//TO PROFILE PAGE
$f3->route('POST /profile', function () {
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    $view = new Template();
    echo $view->render('views/profile.html');
});

//TO INTERESTS PAGE
$f3->route('GET /interests', function () {
    $view = new Template();
    echo $view->render('views/interests.html');
});

//TO SUMMARY PAGE
$f3->route('GET /summary', function () {
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run F3
$f3->run();

