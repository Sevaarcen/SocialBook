<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		$end_url = "profile.php";
		ob_start();
		header("Location ".$end_url);
		ob_end_flush();
		die();
	}
	#grab $connection mysqli object
	require 'database.php';
	
	session_start();
	$username = $_SESSION['username'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

	$email = $_POST['email'];
	$email_rex = "#([a-zA-Z0-9!\\#$%&\\\'\\*\\+\\-=?^_`{|}~\\.\\\"()\\\\,:;<>\\[\\]])+@(\\.?[a-zA-Z0-9\\-]+\\.[a-zA-Z]+)#";
	if (preg_match($email_rex, $email) != 1) {
		 	$_SESSION['profile_message'] = $_SESSION['profile_message'].'<font color="red" ><b>Error: invalid email address<br>(please use address@domain.com format)</b></font>';
			$end_url = "profile.php";
      ob_start();
      header("Location ".$end_url);
      ob_end_flush();
      die();
	}

	$phone = $_POST['phone'];

	if (preg_match("#[0-9]{3}-[0-9]{3}-[0-9]{4}#", $phone) != 1) {
		$_SESSION['profile_message'] = $_SESSION['profile_message'].'<font color="red" ><b>Error: invalid phone number format<br>(please use XXX-XXX-XXXX format)</b></font>';
		$end_url = "profile.php";
    ob_start();
    header("Location ".$end_url);
    ob_end_flush();
    die();
	}

	$birthdate = $_POST['birthdate'];

	$raw_update_query = "UPDATE Users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone', birthdate='$birthdate' WHERE username='$username'";
	$update_query = htmlspecialchars($raw_update_query);
	$result = mysqli_query($connection, $update_query);
	
	$_SESSION['profile_message'] =  $_SESSION['profile_message'].'The changes have been made to your profile!';

	$end_url = "profile.php";
	ob_start();
	header('Location: '.$end_url);
	ob_end_flush();
	exit();
?>
