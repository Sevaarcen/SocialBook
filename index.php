<?php require 'header.php'; ?>

<style>
	body {
		background-color: #f8f8f8;
	}
</style>
<html>
	<head>
	</head>
	<body>
<?php
	if (!isset($_SESSION['username'])) {
		 echo '<h2> Please login or register to use this service!</h2>';
		 echo '<a href="/login.php">Login Here</a>';
		 echo'<br>';
		 echo '<a href="/register.php">Create a new account!</a>';
		 exit();
	}
	echo '<br><a style="font-size: 24px; font-weight: bold;" href="post.php">Write your own post!</a><br><br>';

	require 'database.php';
	$query = "SELECT posted_on, posted_by, content FROM Posts ORDER BY posted_on DESC;";
	$results = mysqli_query($connection, $query);

	while ($row = $results->fetch_assoc()){
		echo 'Posted on <b>'.$row['posted_on'].'</b> by <b>'.$row['posted_by'].'</b>:';
		echo '<br>';
		echo $row['content'];
		echo '<br><br>';
	}
?>
	</body>
</html>
