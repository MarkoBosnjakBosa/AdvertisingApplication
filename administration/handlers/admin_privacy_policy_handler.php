<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM privacy_policy";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
if($counter == 0){
	if(isset($_POST) && !empty($_POST)){
		if(isset($_POST['privacy_policy']) && !empty($_POST['privacy_policy'])){
			$privacy_policy = mysqli_real_escape_string($link, $_POST['privacy_policy']);		
			$submit_query = "INSERT INTO privacy_policy (privacy_policy) VALUES ('$privacy_policy')";
			$submit_result = mysqli_query($link, $submit_query);
			if($submit_result){
				$alert_type = "success";
				$message = "The privacy policy has been successfully submitted!";
			}
			else{
				$alert_type = "danger";
				$message = "The privacy policy couldn't be submitted!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "You have to enter a privacy policy!";
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
	if(isset($_POST['privacy_policy']) && !empty($_POST['privacy_policy'])){
		$privacy_policy = mysqli_real_escape_string($link, $_POST['privacy_policy']);	
		$update_query = "UPDATE privacy_policy SET privacy_policy = '$privacy_policy'";
		$update_result = mysqli_query($link, $update_query);
		if($update_result){
			$alert_type = "success";
			$message = "The privacy policy has been successfully updated!";
		}
		else{
			$alert_type = "danger";
			$message = "The privacy policy couldn't be updated!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "You have to enter a privacy policy!";
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