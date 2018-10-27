<?php
require_once('../../connect.php');
require_once('../../recaptcha.php');
mysqli_set_charset($link,'utf-8');
$secret = "6Let8k8UAAAAAAAK5wgoerEDXhtBS1RU7XJ-eZD7";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if(isset($_POST) && !empty($_POST)){
	if($_POST['recaptcha']){
		$response = $reCaptcha->verifyResponse(
			$_SERVER['REMOTE_ADDR'],
			$_POST['recaptcha']
		);
	}
	if($response != null && $response->success){
		if(isset($_POST['username']) && !empty($_POST['username'])){
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$existing_username_query = "SELECT * FROM users WHERE username = '$username'";
			$existing_username_result = mysqli_query($link, $existing_username_query);
			$username_counter = mysqli_num_rows($existing_username_result);
			if($username_counter == 0){
				$verification_key = md5($username);
				if(isset($_POST['email']) && !empty($_POST['email'])){
					$email = mysqli_real_escape_string($link, $_POST['email']);
					$existing_email_query = "SELECT * FROM users WHERE email = '$email'";
					$existing_email_result = mysqli_query($link, $existing_email_query);
					$email_counter = mysqli_num_rows($existing_email_result);
					if($email_counter == 0){
						if(isset($_POST['password']) && !empty($_POST['password'])){
							$password = mysqli_real_escape_string($link, $_POST['password']);
							if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
								$first_name = mysqli_real_escape_string($link, $_POST['first_name']);
								if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
									$last_name = mysqli_real_escape_string($link, $_POST['last_name']);
									if(isset($_POST['city']) && !empty($_POST['city'])){
										$city = mysqli_real_escape_string($link, $_POST['city']);
										if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
											$telephone = mysqli_real_escape_string($link, $_POST['telephone']);
											$status = "1";
											$privacy_policy = "1";
											$administrator = "1";
											date_default_timezone_set('Europe/Zagreb');
											$date = getdate();
											$registration_time = date('d.m.Y H:i:s');
											$query = "INSERT INTO users (username, first_name, last_name, email, password, city, telephone, verification_key, status, privacy_policy, administrator, registration_time) VALUES ('$username', '$first_name', '$last_name', '$email', '$password', '$city', '$telephone', '$verification_key', '$status', '$privacy_policy', '$administrator', '$registration_time')";
											$result = mysqli_query($link, $query);
											if($result){
												$alert_type = "success";
												$alert_message = "You have successfully created a new administrator!";
											}
											else{
												$alert_type = "danger";
												$alert_message = "Administrator registration has failed!";
											}
										}
										else{
											$alert_type = "danger";
											$alert_message = "Enter a telephone number!";
										}
									}
									else{
										$alert_type = "danger";
										$alert_message = "Enter a city!";
									}
								}
								else{
									$alert_type = "danger";
									$alert_message = "Enter a last name!";
								}
							}
							else{
								$alert_type = "danger";
								$alert_message = "Enter a first name!";
							}
						}
						else{
							$alert_type = "danger";
							$alert_message = "Enter a password!";
						}
					}
					else{
						$alert_type = "danger";
						$alert_message = "Email already exists! Please enter another email!";
					}
				}
				else{
					$alert_type = "danger";
					$alert_message = "Enter an email address!";
				}
			}
			else{
				$alert_type = "danger";
				$alert_message = "Username already exists! Enter another username!";
			}
		}	
		else{
			$alert_type = "danger";
			$alert_message = "Enter a username!";
		}
	}
	else{
		$alert_type = "danger";
		$alert_message = "ReCaptcha must be confirmed!";
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