<html>
	<head>
	</head>
	<body>
	<style>
		table {
			width:auto;
		}
		td {
			white-space:nowrap;
			padding: 5px;
		}
		td:last-child {
			width=100%;
		}
	</style>
	
	<?php require 'header.php'; ?>
	<form action="/register.php" method="POST">
	<table>
		<tr>	
		<td><b>Username</b></td>
		<td width="200"><input required type="text" name="username" placeholder="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>"></td>
		</tr>
		<tr>
		<td><b>Password</b></td>
		<td><input required type="password" name="password"></td>
		</tr>
		<tr>
		<td><b>Confirm Password</b></td>
		<td><input required type="password" name="c_password"></td>
		</tr>
		<tr>
		<td><b>First Name</b></td>
		<td><input required type="text" name="first_name" placeholder="first name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>"></td>
		</tr>
		<tr>
		<td><b>Last Name</b></td>
		<td><input required type="text" name="last_name" placeholder="last name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>"></td>
		</tr>
		<tr>
		<td><b>Email Address</b></td>
		<td><input required type="text" name="email" placeholder="example@domain.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"></td>
		</tr>
		<tr>
		<td><b>Phone Number</b></td>
		<td><input required type="text" name="phone" placeholder="555-555-5555" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>"></td>
		</tr>
		<tr>
		<td><b>Birth Date</b></td>
		<td><input required type="date" name="birthdate" value="<?php echo isset($_POST['birthdate']) ? $_POST['birthdate'] : '' ?>"></td>
		</tr>
		<tr>
		<td></td>
		<td><input type="submit" name="Register"></td>
		</tr>
	</table>
	</form>	
</html>


<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		exit();
	}
	#grab $connection mysqli object
	require 'database.php';

	$username = $_POST['username'];
	# verify username is not taken
	$raw_unamequery = "SELECT username FROM Users WHERE username='$username'";
	$uname_query = htmlspecialchars($raw_unamequery);
	$uname_results = mysqli_query($connection, $uname_query);
	if ($uname_results->num_rows > 0) {
		echo '<font color="red" ><b>Error: username is already in use!</b></font>';
		exit();
	}

	$password = $_POST['password'];

	#verify password matches
	$confirm_password = $_POST['c_password'];
	
	if ($password != $confirm_password) {
		echo '<font color="red" ><b>Error: passwords do not match!</b></font>';
		exit();
	
	}
	$hashed_password = md5($password);

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

	$email = $_POST['email'];

	$email_rex = "#([a-zA-Z0-9!\\#$%&\\\'\\*\\+\\-=?^_`{|}~\\.\\\"()\\\\,:;<>\\[\\]])+@(\\.?[a-zA-Z0-9\\-]+\\.[a-zA-Z]+)#";
	if (preg_match($email_rex, $email) != 1) {
		echo '<font color="red" ><b>Error: invalid email address<br>(please use address@domain.com format)</b></font>';
		exit();
	}

	$phone = $_POST['phone'];

	if (preg_match("#[0-9]{3}-[0-9]{3}-[0-9]{4}#", $phone) != 1) {
		echo '<font color="red" ><b>Error: invalid phone number format<br>(please use XXX-XXX-XXXX format)</b></font>';
		exit();
	}

	$birthdate = $_POST['birthdate'];

	#register new user
	$raw_query = "INSERT INTO Users (admin, username, password, first_name, last_name, email, phone, birthdate) VALUES (false, '$username', '$hashed_password', '$first_name', '$last_name', '$email', '$phone', '$birthdate');";
	$query = htmlspecialchars($raw_query);
	$result = mysqli_query($connection, $query);
	
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['first_name'] = $first_name;
	$_SESSION['last_name'] = $last_name;

	$end_url = "index.php";
	ob_start();
	header('Location: '.$end_url);
	ob_end_flush();
	exit();
?>

</body>
</html>
