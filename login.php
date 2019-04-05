<html>
	<head>
	</head>
	<body>
	 <?php require 'header.php'; ?>
<h1> Please login: </h1>

<form action="login.php" method="post">
	<b>Username:</b><br>
	<input require type="text" name="username"><br>
	<b>Password:</b><br>
	<input require type="password" name="password"><br>
	<input type="submit" value="submit"><br>
</form>

<?php
	#make sure this doesn't run unless the user hits "submit"
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		exit();
	}

	#grab data from post
	$unameform = $_POST['username'];
	$pwform = md5($_POST['password']);

	require 'database.php';
	
	#do query
	$raw_query = "SELECT username, first_name, last_name FROM Users WHERE username='$unameform' AND password='$pwform'";
	$query = htmlspecialchars($raw_query);
	$result = mysqli_query($connection, $query);
	if (!$result) {
		trigger_error('Invalid query: ' . $connection->error);
		die('<font color="red">Uh oh! There was an error. Please contact SocialBook support</font>');
	}
	#parse results
	if ($result->num_rows == 1){
		$row = $result->fetch_assoc();
		
		$id = $row['id'];
		$username = $row['username'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];

		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['first_name'] = $first_name;
		$_SESSION['last_name'] = $last_name;

		$end_url = "index.php";
		ob_start();
		header('Location: '.$end_url);
		ob_end_flush();
		exit();
	}
	elseif ($result->num_rows > 1) {
		exit('<font color="red">Uh oh!  Please contact Socialbook Support</font>');
	}
	else {
		echo '<font color="red">There was an error. Your username or password is incorrect!</font>';
	}
?>
</body>
</html>
