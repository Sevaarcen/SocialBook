<?php
	# "start" the session to grab it
	session_start();
	#then kill it
	session_destroy();
	
	#redirect to the homepage
	$end_url = "index.php";
	ob_start();
	header('Location: '.$end_url);
	ob_end_flush();
	die();
?>
