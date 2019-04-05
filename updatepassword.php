<?php
  if($_SERVER['REQUEST_METHOD'] != 'POST') {
    $end_url = "profile.php";
    ob_start();
    header("Location: ".$end_url);
    ob_end_flush();
    die();
  }
  #grab $connection mysqli object
  require 'database.php';

  session_start();
  $username = $_SESSION['username'];
  if(isset($_POST['current_password']) && !empty($_POST['current_password'])){
    if(isset($_POST['new_password'])  && !empty($_POST['new_password']) && isset($_POST['c_new_password']) && !empty($_POST['c_new_password'])){
      $grab_pw_query = "SELECT password FROM Users WHERE username='$username';";
      $pw_result = mysqli_query($connection, $grab_pw_query);
      $pw_row = $pw_result->fetch_assoc();
      $password = $pw_row['password'];
      $current_password_raw = $_POST['current_password'];
      $current_password = md5($current_password_raw);
      if($password != $current_password) {
        $_SESSION['password_message'] = '<font color="red" >Your current password is incorrect!</font color="red" >';
        $end_url = "profile.php";
        ob_start();
        header("Location: ".$end_url);
        ob_end_flush();
        exit();
      }
      $new_password = md5($_POST['new_password']);
      $c_new_password = md5($_POST['c_new_password']);
      if($new_password != $c_new_password){
        $_SESSION['password_message'] = '<font color="red" >Your new password and the confirmation don\'t match!</font color="red" >';
        $end_url = "profile.php";
        ob_start();
        header("Location: ".$end_url);
        ob_end_flush();
        exit();
      }
      $update_pw_query = "UPDATE Users SET password='$new_password' WHERE username='$username';";
      $update_pw_result = mysqli_query($connection, $update_pw_query);
      $_SESSION = "Your password has been changed";
      exit();
    }
    else {
      $_SESSION['password_message'] = '<font color="red" >You must also input your new password and confirm!</font color="red" >';
      $end_url = "profile.php";
      ob_start();
      header("Location: ".$end_url);
      ob_end_flush();
      exit();
    }
  }
?>
