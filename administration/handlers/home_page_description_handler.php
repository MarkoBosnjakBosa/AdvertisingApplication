<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_description";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
if($counter == 0){
	if(isset($_POST) && !empty($_POST)){
		if(isset($_POST['description']) && !empty($_POST['description'])){
			$description = mysqli_real_escape_string($link, $_POST['description']);		
			$submit_query = "INSERT INTO home_page_description (description) VALUES ('$description')";
			$submit_result = mysqli_query($link, $submit_query);
			if($submit_result){
				$alert_type = "success";
				$message = "The description has been successfully submitted!";
			}
			else{
				$alert_type = "danger";
				$message = "The description couldn't be submitted!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "You have to enter a description!";
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
	if(isset($_POST['description']) && !empty($_POST['description'])){
		$description = mysqli_real_escape_string($link, $_POST['description']);	
		$update_query = "UPDATE home_page_description SET description = '$description'";
		$update_result = mysqli_query($link, $update_query);
		if($update_result){
			$alert_type = "success";
			$message = "The description has been successfully updated!";
		}
		else{
			$alert_type = "danger";
			$message = "The description couldn't be updated!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "You have to enter a description!";
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