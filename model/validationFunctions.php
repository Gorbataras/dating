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
	//If its not empty and uses only characters
		return !empty($string) && ctype_alpha($string);
	}

	function validAge($age) {
	//If not empty and is number and reasonable age
		return !empty($age) && is_numeric($age) && $age < 130 && $age > 0;
	}

	function validPhone($phone) {
	// if not empty and is right format
		return !empty($phone) && preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
	}

	function validEmail($email) {
	// if not empty and is email format
		return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	function validOutdoor($activity) {
	// Parses through the given hive array and checks if the current key is in it.
		$subvalid=FALSE;
		if (!empty($activity)) {
			foreach ($activity as $key=>$value) {
				if (!in_array($key,$activity)) {
					$subvalid=TRUE;
				}
			}
		}
		return $subvalid;

	}

	function validIndoor($activity) {
		// Parses through the given hive array and checks if the current key is in it.
		$subvalid=FALSE;
		if (!empty($activity)) {
			foreach ($activity as $key=>$value) {
				if (!in_array($key , $activity)) {
					$subvalid=TRUE;
				}
			}
		}
		return $subvalid;
	}
