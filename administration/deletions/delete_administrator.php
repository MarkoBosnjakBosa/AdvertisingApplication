<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$user_query = "SELECT * FROM users WHERE id = '$id'";
	$user_result = mysqli_query($link, $user_query);
	$user_fetch_result = mysqli_fetch_assoc($user_result);
	$user = $user_fetch_result['username'];
	$query = "UPDATE users SET administrator = 0 WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	if($query){
		$alert_type = "success";
		$message = "The permission for user " . $user . " has been successfully removed!";
	}
	else{
		$alert_type = "danger";
		$message = "The permission for user " . $user . " couldn't be removed!";
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