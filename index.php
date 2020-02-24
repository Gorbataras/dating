<?php


// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require("vendor/autoload.php");
require("model/validationFunctions.php");
session_start();
// Instantiate F3
$f3 = Base::instance();

$f3->set('DEBUG', 3);

$controller = new MemberController($f3);

$f3->set('indoorOptions', 	array(	'tv'=>'TV',
									'movies'=>'Movies',
									'cooking'=>'Cooking',
									'boardgames'=>'Board Games',
									'puzzles'=>'Puzzles',
									'reading'=>'Reading',
									'playingcards'=>'Playing Cards',
									'videogames'=>'Video Games'
));

$f3->set('outdoorOptions', array(	'hiking'=>'Hiking',
									'biking'=>'Biking',
									'swimming'=>'Swimming',
									'collecting'=>'Collecting',
									'walking'=>'Walking',
									'climbing'=>'Climbing'
));

$f3->set('genderOptions', array('male', 'female'));



// Defining a default route
$f3->route('GET /', function () {
	$GLOBALS['controller']->home();
});

//TO PERSONAL INFO PAGE
$f3->route('GET|POST /personal', function () {
	$GLOBALS['controller']->personal();
});

//TO PROFILE PAGE
$f3->route('GET|POST /profile', function () {
	$GLOBALS['controller']->profile();
});

//TO INTERESTS PAGE
$f3->route('GET|POST /interests', function ($f3) {
	$GLOBALS['controller']->interests();
});

//TO SUMMARY PAGE

$f3->route('GET /summary', function () {
	$GLOBALS['controller']->summary();
});

// Run F3
$f3->run();

