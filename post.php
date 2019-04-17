<html>
	<head>
	</head>
	<body>

	<style>
		table {
			width: 100%;
		}
		td {
			width: 100%;
		}
	</style>
</html>

<?php
	require 'header.php';

	if (!isset($_SESSION['username'])) {
		$end_url = "index.php";
		ob_start();
		header('Location: '.$end_url);
		ob_end_flush();
		die();
	}

	if ($_SERVER['REQUEST_METHOD'] != "POST") {
		echo '<form action="post.php" method="post" id="post_form">';
			echo '<table>';
				echo '<tr><td>';
					echo '<textarea name="content" form="post_form" cols="45" rows="10" placeholder="Post here, you can even use <b>HTML</b> styling! 256 character limit. Try and include at least 1 personal detail about your life, thanks."></textarea>';
				echo '</td></tr>';
				echo '<tr><td>';
					echo '<input type="submit" value="Post">';
				echo '</td></tr>';
			echo '</table>';
		echo '</form>';
		exit();
	}

	$username = $_SESSION['username'];
	$content = $_POST['content'];
	$sanitized_content = preg_replace("#</?[sS][cC][rR][iI][pP][tT]>#", "", $content);

	# add post
	require 'database.php';
	$query = "INSERT INTO Posts (posted_on, posted_by, content) VALUES (NOW(), '$username', '$sanitized_content');";
	$result = mysqli_multi_query($connection, $query);

	$end_url = "index.php";
	ob_start();
	header('Location: '.$end_url);
	ob_end_flush();
	exit();
?>

</body>
</html>
