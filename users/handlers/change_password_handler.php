<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['old_password']) && !empty($_POST['old_password'])){
		$old_password = mysqli_real_escape_string($link, $_POST['old_password']);
		$password_query = "SELECT * FROM users WHERE username = '$username'";
		$password_result = mysqli_query($link, $password_query);
		$password_fetch_result = mysqli_fetch_assoc($password_result);
		if($old_password == $password_fetch_result['password']){			
			if(isset($_POST['new_password']) && !empty($_POST['new_password'])){
				$new_password = mysqli_real_escape_string($link, $_POST['new_password']);
				$update_password = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
				$update_password_result = mysqli_query($link, $update_password);
				if($update_password_result){
					$alert_type = "success";
					$alert_message = "The password has been updated!";
				}
				else{
					$alert_type = "danger";
					$alert_message = "The password couldn't be updated!";
				}
			}
			else{
				$alert_type = "danger";
				$alert_message = "Enter new password!";
			}
		}
		else{
			$alert_type = "danger";
			$alert_message = "The entered password doesn't match the current password!";
		}
	}
	else{
		$alert_type = "danger";
		$alert_message = "Enter current password!";
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $alert_message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
?>