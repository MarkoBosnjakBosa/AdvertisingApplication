<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_information";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
if($counter == 0){
	if(isset($_POST) && !empty($_POST)){
		if(isset($_POST['name']) && !empty($_POST['name'])){
			$name = mysqli_real_escape_string($link, $_POST['name']);
			if(isset($_POST['address']) && !empty($_POST['address'])){
				$address = mysqli_real_escape_string($link, $_POST['address']);
				if(isset($_POST['city']) && !empty($_POST['city'])){
					$city = mysqli_real_escape_string($link, $_POST['city']);
					if(isset($_POST['country']) && !empty($_POST['country'])){
						$country = mysqli_real_escape_string($link, $_POST['country']);
						if(isset($_POST['email']) && !empty($_POST['email'])){
							$email = mysqli_real_escape_string($link, $_POST['email']);
							if(isset($_POST['fax']) && !empty($_POST['fax'])){
								$fax = mysqli_real_escape_string($link, $_POST['fax']);
								if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
									$telephone = mysqli_real_escape_string($link, $_POST['telephone']);							
									$submit_query = "INSERT INTO home_page_information (name, address, city, country, email, fax, telephone) VALUES ('$name', '$address', '$city', '$country', '$email', '$fax', '$telephone')";
									$submit_result = mysqli_query($link, $submit_query);
									if($submit_result){
										$alert_type = "success";
										$message = "The information has been successfully submitted!";
									}
									else{
										$alert_type = "danger";
										$message = "The information couldn't be submitted!";
									}
								}
								else{
									$alert_type = "danger";
									$message = "You have to enter a telephone number!";
								}
							}
							else{
								$alert_type = "danger";
								$message = "You have to enter a fax number!";
							}
						}
						else{
							$alert_type = "danger";
							$message = "You have to enter an email address!";
						}
					}
					else{
						$alert_type = "danger";
						$message = "You have to enter a country!";
					}
				}
				else{
					$alert_type = "danger";
					$message = "You have to enter a city!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "You have to enter an address!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "You have to enter a name!";
		}
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
else{
	$fetch_result = mysqli_fetch_assoc($result);
	if(isset($_POST) && !empty($_POST)){
		if(isset($_POST['name']) && !empty($_POST['name'])){
			$name = mysqli_real_escape_string($link, $_POST['name']);
			if(isset($_POST['address']) && !empty($_POST['address'])){
				$address = mysqli_real_escape_string($link, $_POST['address']);
				if(isset($_POST['city']) && !empty($_POST['city'])){
					$city = mysqli_real_escape_string($link, $_POST['city']);
					if(isset($_POST['country']) && !empty($_POST['country'])){
						$country = mysqli_real_escape_string($link, $_POST['country']);
						if(isset($_POST['email']) && !empty($_POST['email'])){
							$email = mysqli_real_escape_string($link, $_POST['email']);
							if(isset($_POST['fax']) && !empty($_POST['fax'])){
								$fax = mysqli_real_escape_string($link, $_POST['fax']);
								if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
									$telephone = mysqli_real_escape_string($link, $_POST['telephone']);		
									$update_query = "UPDATE home_page_information SET name = '$name', address = '$address', city = '$city', country = '$country', email = '$email', fax = '$fax', telephone = '$telephone'";
									$update_result = mysqli_query($link, $update_query);
									if($update_result){
										$alert_type = "success";
										$message = "The information has been successfully updated!";
									}
									else{
										$alert_type = "danger";
										$message = "The information couldn't be updated!";
									}
								}
								else{
									$alert_type = "danger";
									$message = "You have to enter a telephone number!";
								}
							}
							else{
								$alert_type = "danger";
								$message = "You have to enter a fax number!";
							}
						}
						else{
							$alert_type = "danger";
							$message = "You have to enter an email address!";
						}
					}
					else{
						$alert_type = "danger";
						$message = "You have to enter a country!";
					}
				}
				else{
					$alert_type = "danger";
					$message = "You have to enter a city!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "You have to enter an address!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "You have to enter a name!";
		}
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}