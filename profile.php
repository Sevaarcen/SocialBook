<html>
	<head>
	</head>
	<body>
		<style>
			table {
				width: 100%;
			}
			td {
				padding: 5px;
			}
			.content {
			}
			.left {
				width: calc(40% - 20px);
				min-width: 350px;
				float: left;
				padding: 10px 10px;
			}
			.right {
				width: calc(60% - 20px);
				overflow: hidden;
				padding: 10px 10px;
			}
			.right img {
				width: 100%;
				height: auto;
				max-width: 512px;
			}
		</style>
		
		<?php
			require 'header.php';
			require 'database.php';
					
			$username = $_SESSION['username'];
			$query = "SELECT * FROM Users WHERE username='$username';";
			$result = mysqli_query($connection, $query);
							
			if ($result->num_rows != 1) {
				die("Uh oh! Contact SocialBook support!");
			}
			
			$row = $result->fetch_assoc();
			
			$username = $row['username'];
			$password = $row['password'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$email = $row['email'];
			$phone = $row['phone'];
			$birthdate = $row['birthdate'];
			$profile_pic_url = $row['profile_picture'];
			
			echo '<div class="content">';
					echo '<div class="left">';	
						echo '<form action="updateprofile.php" method="post">';
							echo '<table class="update-form">';
								echo '<h3>Update Account Details</h3>';
								echo '<tr>';
									echo '<td style="width:40%;">';
										echo '<b>Username</b>';
									echo '</td>';
									echo '<td>';
										echo "<input required type='text' name='username' value='$username' disabled>";
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
                  echo '<td>';
                    echo '<b>First Name</b>';
                  echo '</td>';
                  echo '<td>';
                    echo "<input required type='text' name='first_name' value='$first_name'>";
                  echo '</td>';
                echo '</tr>';
								echo '<tr>';
                  echo '<td>';
                    echo '<b>Last Name</b>';
                  echo '</td>';
                  echo '<td>';
                    echo "<input required type='text' name='last_name' value='$last_name'>";
                  echo '</td>';
                echo '</tr>';
								echo '<tr>';
                  echo '<td>';
                    echo '<b>Email Address</b>';
                  echo '</td>';
                  echo '<td>';
                    echo "<input required type='text' name='email' value='$email'>";
                  echo '</td>';
                echo '</tr>';
								echo '<tr>';
									echo '<td>';
										echo '<b>Phone Number</b>';
									echo '</td>';
									echo '<td>';
										echo "<input required type='text' name='phone' value='$phone'>";
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
                  echo '<td>';
                    echo '<b>Birthdate</b>';
                  echo '</td>';
                  echo '<td>';
                    echo "<input required type='date' name='birthdate' value='$birthdate'>";
                  echo '</td>';
                echo '</tr>';
								echo '<tr>';
									echo '<td>';
										echo '<input type="submit" value="Change Details">';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						if(isset($_SESSION['profile_message'])){
              $message = $_SESSION['profile_message'];
             	unset($_SESSION['profile_message']);
              echo "<h3>$message</h3>";
            }
						
						echo '<br>';
							
						echo '<form action="updatepassword.php" method="post">';
							echo '<table class="update-form">';
								echo '<tr>';
									echo '<td>';
										echo'<h3>Change Password</h3>';
									echo'</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td style="width:40%;">';
										echo'<b>Current Password</b>';
									echo '</td>';
									echo '<td>';
										echo '<input type="password" name="current_password">';
									echo '</td>';
								echo '</tr>';
							 	echo '<tr>';
                  echo '<td><b>New Password</b></td>';
                  echo '<td><input type="password" name="new_password"></td>';
                echo '</tr>';
								echo '<tr>';
                	echo '<td><b>Confirm New Password</b></td>';
                	echo '<td><input type="password" name="c_new_password"></td>';
                echo '</tr>';
								echo '<tr>';
                	echo '<td>';
                    echo '<input type="submit" value="Update Password">';
                	echo '</td>';
              	echo '</tr>';
							echo '</table>';
						echo '</form>';
						if(isset($_SESSION['password_message'])){
							$message = $_SESSION['password_message'];
							unset($_SESSION['password_message']);
							echo "<h3>$message</h3>";
						}
				
					echo '</div>';

					
					
					#right panel
					echo '<div class="right">';
						if(isset($profile_pic_url)) {
							echo "<img src='$profile_pic_url'>";
						} else {
							echo "<font color='red'>You don't have a profile picture yet, why don't you add one? Please make sure it is a good picture that contains your face</font>";
						}
						echo '<form action="uploadprofilepic.php" method="post" enctype="multipart/form-data">';
							echo '<input type="file" name="picture" accept="image/*">';
							echo '<input type="submit" value="Upload">';
						echo '</form>';

						if(isset($_SESSION['upload_message'])){
							$message = $_SESSION['upload_message'];
							unset($_SESSION['upload_message']);
							echo "<h3>$message</h3>";
						}
					echo '</div>';		
		echo '</div>';
	echo '</body>';
echo '</html>';
?>
