<?php

class MemberController
{
	private $_f3;

	public function __construct($f3)
	{
		$this->_f3 = $f3;
	}

	public function home()
	{
		$view = new Template();
		echo $view->render('views/home.html');
	}

	public function personal()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			//Get data from form
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$age = $_POST['age'];
			$gender = $_POST['gender'];
			$phone = $_POST['phone'];
			$membership = $_POST['membership'];

			//Add to Hive
			$this->_f3->set('fname', $fname);
			$this->_f3->set('lname', $lname);
			$this->_f3->set('age', $age);
			$this->_f3->set('gender', $gender);
			$this->_f3->set('phone', $phone);
			$this->_f3->set('membership', $phone);

			//Gender is optional
			$_SESSION['gender'] = $gender;


			if (validatePersonal()) {
				$_SESSION['fname'] = $fname;
				$_SESSION['lname'] = $lname;
				$_SESSION['age'] = $age;
				$_SESSION['phone'] = $phone;

				//Before reroute, add info to obj
				if ($membership == 'Premium') {
					$_SESSION['membership'] = $membership;
					$_SESSION['member'] = new PremiumMember($fname, $lname, $age, $phone, $gender);
				} else {
					$_SESSION['membership'] = 'Basic';
					$_SESSION['member'] = new Member($fname, $lname, $age, $phone, $gender);
				}
				$this->_f3-> reroute('/profile');
			}
		}

		$view = new Template();
		echo $view->render('views/personal_info.html');
	}

	public function profile()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$email=$_POST['email'];
			$state=$_POST['state'];
			$bio=$_POST['bio'];
			$seeking=$_POST['seeking'];

			$this->_f3->set('email',$email);
			$this->_f3->set('state',$state);
			$this->_f3->set('bio',$bio);
			$this->_f3->set('seeking',$seeking);

			//Not Required
			$_SESSION['bio']=$bio;
			$_SESSION['state']=$state;
			$_SESSION['seeking']=$seeking;


			if (validateProfile()) {
				$_SESSION['email']=$email;
				$member= $_SESSION['member'];
				$member->setEmail($email);
				$member->setState($state);
				$member->setBio($bio);
				$member->setSeeking($seeking);

				$_SESSION['member'] = $member;

				$this->_f3->reroute('/interests');

			}
		}

		$view = new Template();
		echo $view->render('views/profile.html');
	}

	public function interests()
	{
		if (!($_SESSION['member'] instanceof PremiumMember)){
			$this->_f3->reroute('/summary');
		} else {
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				$indoorInterests=$_POST['indoor'];
				$outdoorInterests=$_POST['outdoor'];

				$this->_f3->set('indoorInterests',$indoorInterests);
				$this->_f3->set('outdoorInterests',$outdoorInterests);

				if (validateInterests()) {
					$_SESSION['member']->setInDoorInterests($indoorInterests);
					$_SESSION['member']->setOutDoorInterests($outdoorInterests);
					$_SESSION['indoorString']=implode(", ",$indoorInterests);
					$_SESSION['outdoorString']=implode(", ",$outdoorInterests);
					$this->_f3->reroute('/summary');
				}
			}
			$view=new Template();
			echo $view->render('views/interests.html');
		}
	}

	public function summary()
	{
		$view = new Template();
		echo $view->render('views/summary.html');
		session_destroy();
	}
}