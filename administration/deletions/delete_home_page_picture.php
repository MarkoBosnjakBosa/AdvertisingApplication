<?php
require_once('../../connect.php');
mysqli_set_charset($link,'utf-8');
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$query = "SELECT * FROM home_page_pictures WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$title = $fetch_result['title'];
	$picture_title = "../" . $title;
	if(file_exists($picture_title)){
		if(unlink($picture_title)){
			$picture_query = "DELETE FROM home_page_pictures WHERE id = '$id'";
			$picture_result = mysqli_query($link, $picture_query);
			if($picture_result){
				$alert_type = "success";
				$message = "The picture has been successfully deleted!";
			}
			else{
				$alert_type = "danger";
				$message = "The picture couldn't be deleted!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "The picture is already deleted from the folder!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "The picture is already deleted from the folder!";
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