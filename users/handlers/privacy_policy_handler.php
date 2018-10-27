<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST['username']) && !empty($_POST['username'])){
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$query = "UPDATE users SET privacy_policy = 1 WHERE username = '$username'";
	$query = mysqli_query($link, $query);
	if($query){
		$alert_type = "success";
		$message = "The privacy policy has been successfully updated!";
	}
	else{
		$alert_type = "danger";
		$message = "The privacy policy couldn't be updated!";
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}