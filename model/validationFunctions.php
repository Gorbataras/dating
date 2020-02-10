<?php


function validatePersonal(){
	global $f3;
	$isValid = true;
	if (!validName($f3->get('fname'))) {
		$isValid = false;
		$f3->set("errors['fname']", "Please enter your name");
	}

	if(!validName($f3->get('lname'))) {
		$isValid = false;
		$f3->set("errors['lname']", "Please enter your name");
	}

	if (!validAge($f3->get('age'))) {
		$isValid = FALSE;
		$f3->set("errors['age']", "Please enter your age");
	}

	if (!validPhone($f3->get('phone'))) {
		$isValid = FALSE;
		$f3->set("errors['phone']", "Please enter a valid 10 - digit phone number");
	}
	return $isValid;
}

function validateProfile() {
	global $f3;
	$isValid = true;
	if (!validEmail($f3->get('email'))) {
		$isValid = false;
		$f3->set("errors['email']", "Please enter a valid email");
	}
	return $isValid;
}

function validateInterests() {
	global $f3;
	$isValid = TRUE;
	if (!validIndoor($f3->get('indoorInterests'))) {
		$isValid = false;
		$f3->set("errors['indoor']", "Please choose some interests");
	}

	if(!validOutdoor($f3->get('outdoorInterests'))) {
		$isValid = FALSE;
		$f3->set("errors['outdoor']", "Please choose some interests");
	}


	return $isValid;
}

	function validName($string) {
		return !empty($string) && ctype_alpha($string);
	}

	function validAge($age) {
		return !empty($age) && is_numeric($age) && $age < 150 && $age > 0;
	}

	function validPhone($phone) {
		return !empty($phone) && preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
	}

	function validEmail($email) {
		return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	function validOutdoor($activity) {
		global $f3;
		return in_array($activity, $f3->get('outdoorOptions'));
	}

	function validIndoor($activity) {
		global $f3;
		return in_array($activity, $f3->get('indoorOptions'));
	}
