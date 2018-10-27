<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['id']) && !empty($_POST['id'])){
		$id = mysqli_real_escape_string($link, $_POST['id']);
		if(isset($_POST['email']) && !empty($_POST['email'])){
			$email = mysqli_real_escape_string($link, $_POST['email']);
			$email_query = "SELECT * FROM users WHERE email = '$email'";
			$email_result = mysqli_query($link, $email_query);
			$email_counter = mysqli_num_rows($email_result);			
			$username_email_query = "SELECT * FROM users WHERE username = '$username'";
			$username_email_result = mysqli_query($link, $username_email_query);
			$username_email_fetch_result = mysqli_fetch_assoc($username_email_result);
			$username_email = $username_email_fetch_result['email'];			
			if(($email_counter == 0) || (($username_email == $email) && ($email_counter == 1))){
				if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
					$first_name = mysqli_real_escape_string($link, $_POST['first_name']);
					if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
						$last_name = mysqli_real_escape_string($link, $_POST['last_name']);
						if(isset($_POST['city']) && !empty($_POST['city'])){
							$city= mysqli_real_escape_string($link, $_POST['city']);
							if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
								$telephone = mysqli_real_escape_string($link, $_POST['telephone']);
								$update_query = "UPDATE users SET email = '$email', first_name = '$first_name', last_name = '$last_name', city = '$city', telephone = '$telephone' WHERE username = '$username' AND administrator = 1";
								$update_result = mysqli_query($link, $update_query);
								if($update_result){
									$alert_type = "success";
									$message = "Profile has been updated!";
								}
								else{
									$alert_type = "danger";
									$message = "Profile couldn't be updated!";
								}
							}
							else{
								$alert_type = "danger";
								$message = "Enter your telephone number!";
							}
						}
						else{
							$alert_type = "danger";
							$message = "Enter your city!";
						}
					}
					else{
						$alert_type = "danger";
						$message = "Enter your last name!";
					}
				}
				else{
					$alert_type = "danger";
					$message = "Enter your first name!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "Entered email address is already taken!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "Enter your email address!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "The ad couldn't be updated!";
	}	
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
?>