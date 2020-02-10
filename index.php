<?php

session_start();
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require("vendor/autoload.php");
require("model/validationFunctions.php");

// Instantiate F3
$f3 = Base::instance();

$f3->set('DEBUG', 3);

$f3->set('indoorOptions', 	array(	'tv',
									'movies',
									'cooking',
									'boardgames',
									'puzzles',
									'reading',
									'playingcards',
									'videogames'
));

$f3->set('outdoorOptions', array(	'hiking',
									'biking',
									'swimming',
									'collecting',
									'walking',
									'climbing'
));

// Defining a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//TO PERSONAL INFO PAGE
$f3->route('GET|POST /personal', function ($f3) {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		echo ($f3->get('ERROR.text'));
		//Get data from form
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$phone = $_POST['phone'];

		//Add to Hive
		$f3->set('fname', $fname);
		$f3->set('lname', $lname);
		$f3->set('age', $age);
		$f3->set('gender', $gender);
		$f3->set('phone', $phone);

		//Gender is optional
		$_SESSION['gender'] = $gender;

		if (validatePersonal()) {
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$_SESSION['age'] = $age;
			$_SESSION['phone'] = $phone;

			$f3-> reroute('/profile');
		}
	}



    $view = new Template();
    echo $view->render('views/personal_info.html');
});

//TO PROFILE PAGE
$f3->route('GET|POST /profile', function ($f3) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {


		$email=$_POST['email'];
		$state=$_POST['state'];
		$bio=$_POST['bio'];
		$seeking=$_POST['seeking'];

		$f3->set('email',$email);
		$f3->set('state',$state);
		$f3->set('bio',$bio);
		$f3->set('seeking',$seeking);

		//Not Required
		$_SESSION['bio']=$bio;
		$_SESSION['state']=$state;
		$_SESSION['seeking']=$seeking;


		if (validateProfile()) {
			$_SESSION['email']=$email;
			$f3->reroute('/interests');

		}
	}

    $view = new Template();
    echo $view->render('views/profile.html');
});

//TO INTERESTS PAGE
$f3->route('GET|POST /interests', function ($f3) {

	var_dump($_SESSION);

	$indoorInterests = $_POST['indoor'];
	$outdoorInterests = $_POST['outdoor'];

	$f3->set('indoorInterests', $indoorInterests);
	$f3->set('outdoorInterests', $outdoorInterests);


	if (validateInterests()) {
		$_SESSION['indoorString']=implode(", ",$indoorInterests);
		$_SESSION['outdoorString']=implode(", ",$outdoorInterests);
		$f3->reroute('/summary');
    }

    $view = new Template();
    echo $view->render('views/interests.html');
});

//TO SUMMARY PAGE
$f3->route('POST /summary', function () {

    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run F3
$f3->run();

