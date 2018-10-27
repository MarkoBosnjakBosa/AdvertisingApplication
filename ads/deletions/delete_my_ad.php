<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$success_counter = 0;
	$counter = 0;
	$pictures_query = "SELECT * FROM ads_pictures WHERE ad_id = '$id'";
	$pictures_result = mysqli_query($link, $pictures_query);	
	$pictures_counter = mysqli_num_rows($pictures_result);
	if($pictures_counter > 0){
		while($pictures_fetch_result = mysqli_fetch_assoc($pictures_result)){ 
			$picture_title = $pictures_fetch_result['title'];
			$picture_location = "../" . $picture_title;
			if(file_exists($picture_location)){
				if(unlink($picture_location)){
					$delete_pictures_query = "DELETE FROM ads_pictures WHERE ad_id = '$id'";
					$delete_pictures_result = mysqli_query($link, $delete_pictures_query);
					if($delete_pictures_result){
						$counter++;
					}
					else{
						$alert_type = "danger";
						$message = "The ad couldn't be deleted!";
					}
				}
				else{
					$alert_type = "danger";
					$message = "The picture has been already deleted from the folder!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "The picture has been already deleted from the folder!";
			}
		}
		if($pictures_counter == $counter){
			$success_counter++;
		}
		else{
			$alert_type = "danger";
			$message = "Pictures couldn't be deleted!";
		}
	}
	else{
		$success_counter++;
	}
	$comments_query = "SELECT * FROM comments WHERE ad_id = '$id'";
	$comments_result = mysqli_query($link, $comments_query);
	$comments_counter = mysqli_num_rows($pictures_result);
	if($comments_counter > 0){
		$delete_comments_query = "DELETE FROM comments WHERE ad_id = '$id'";
		$delete_comments_result = mysqli_query($link, $delete_comments_query);
		if($delete_comments_result){
			$success_counter++;	
		}
		else{
			$alert_type = "danger";
			$message = "Comments couldn't be deleted!";
		}
	}
	else{
		$success_counter++;
	}
	$ad_avatar_query = "SELECT * FROM ads WHERE id = '$id'";
	$ad_avatar_result = mysqli_query($link, $ad_avatar_query);
	$ad_avatar_fetch_result = mysqli_fetch_assoc($ad_avatar_result);
	$ad_avatar_title = $ad_avatar_fetch_result['ad_picture'];
	$ad_avatar_location = "../" . $ad_avatar_title;
	if(file_exists($ad_avatar_location)){
		if(unlink($ad_avatar_location)){
			$ad_query = "DELETE FROM ads WHERE id = '$id'";
			$ad_result = mysqli_query($link, $ad_query);
			if($ad_result){
				$success_counter++;
			}
			else{
				$alert_type = "danger";
				$message = "The ad couldn't be deleted!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "The picture has been already deleted from the folder!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "The picture has been already deleted from the folder!";
	}
	if($success_counter == 3){
		$alert_type = "success";
		$message = "The ad has been successfully deleted!";
	}
	else{
		$alert_type = "danger";
		$message = "The ad couldn't be deleted!";
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