<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		$end_url = "index.php";
    ob_start();
    header('Location: '.$end_url);
    ob_end_flush();
    die();
	}

	session_start();
	$target_dir = "pictures/";
	$username = $_SESSION['username'];
	$encoded_username = urlencode($username);

	$target_file = $target_dir.$encoded_username."_".$_FILES["picture"]['name'];
	
	$filetype = $_FILES['picture']['type'];
	if (!preg_match('#image/.*#', $filetype)) {
		$_SESSION['upload_message'] = "Error: bad filetype. It must be an image!";
		$end_url = "profile.php";
  	ob_start();
  	header('Location: '.$end_url);
  	ob_end_flush();
  	die();
	}

	move_uploaded_file($_FILES['picture']['tmp_name'], $target_file);
	echo "The file is at: ".$target_file;

	require 'database.php';
	$query = "UPDATE Users SET profile_picture='$target_file' WHERE username='$username'";
	$result = mysqli_query($connection, $query);

	$_SESSION['upload_message'] = "Success! Image has been updated and is at: ".$target_file;
  $end_url = "profile.php";
  ob_start();
  header('Location: '.$end_url);
  ob_end_flush();
  die();
?>
