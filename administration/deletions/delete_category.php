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
	$delete_category = "DELETE FROM categories WHERE id = $id";
	$result = mysqli_query($link, $delete_category);
	if($result){
		$alert_type = "success";
		$message = "The category has been successfully deleted!";
	}
	else{
		$alert_type = "danger";
		$message = "The category couldn't be deleted!";
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