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
	$ad_query = "SELECT * FROM ads WHERE user_id = '$id'";
	$ad_result = mysqli_query($link, $ad_query);
	$ad_counter = mysqli_num_rows($ad_result);
	if($ad_counter == 0){	
		$profile_picture_query = "SELECT * FROM users WHERE id = '$id'";
		$profile_picture_result = mysqli_query($link, $profile_picture_query);
		$profile_picture_fetch_result = mysqli_fetch_assoc($profile_picture_result);
		$profile_picture_title = $profile_picture_fetch_result['profile_picture'];
		if($profile_picture_title != ""){
			$profile_picture_location = "../../users/" . $profile_picture_title;
			if(file_exists($profile_picture_location)){
				if(unlink($profile_picture_location)){
					$profile_picture_query = "DELETE FROM users WHERE id = '$id'";
					$profile_picture_result = mysqli_query($link, $profile_picture_query);
					if($profile_picture_result){
						$alert_type = "success";
						$message = "The profile has been successfully deleted!";
					}
					else{
						$alert_type = "danger";
						$message = "The profile couldn't be deleted!";
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
		}
		else{
			$user_query = "DELETE FROM users WHERE id = '$id'";
			$user_result = mysqli_query($link, $user_query);
			if($user_result){
				$alert_type = "success";
				$message = "The profile has been successfully deleted!";
			}
			else{
				$alert_type = "danger";
				$message = "The profile couldn't be deleted!";
			}
		}
	}
	else{
		$alert_type = "danger";
		$message = "The profile couldn't be deleted!
		You have to delete his ads first!";
	}
	$display_message = "
		<div class='alert alert-". $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
?>