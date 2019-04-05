	<style>
		.header {
			overflow: hidden;
			background-color: #4286f4;
			padding: 20px 10px;
		}
		.header a.logo {
			padding: 12px;
			font-size: 32px;
			font-weight: bold;
			text-decoration: underline;
			border-style: none;
		}
		.header a {
			float: left;
			color: black;
			text-align: center;
			padding: 12px;
			text-decoration: none;
			font-size: 16px;
			line-height: 25px;
			border-radius: 4px;
			font-weight: bold;
			border-style: solid;
			border-width: 2px;
			border-color: #164ba0;
		}
		.header a:hover {
			background-color: #b6d0f9;
			color: black;
		}
		.header-right {
			float: right;
		}
		.welcome {
			float: left;
			text-align: center;
			padding: 12px;
			line-height: 25px;
		}
	</style>
	
	<div class="header">
		<a href="index.php" class="logo">SocialBook</a>

		<?php
			session_start();
			if (!isset($_SESSION['username'])) {
				echo '<div class="header-right">';
					echo '<a href="login.php">Login</a>';
					echo '<a  href="register.php">Create Account</a>';
				echo '</div>';
			} else {
				echo '<div class="header-right">';
					echo '<div class="welcome">';
						 echo "Welcome, <b>".$_SESSION['first_name']."</b>";
					echo '</div>';
					echo '<a href="profile.php">Profile</a>';
					echo '<a  href="logout.php">Logout</a>';
				echo '</div>';
			}

		?>
	</div>
</html>
