<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_social_networks";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
if($counter == 0){
	if(isset($_POST) && !empty($_POST)){
		$facebook_url = mysqli_real_escape_string($link, $_POST['facebook_url']);
		$twitter_url = mysqli_real_escape_string($link, $_POST['twitter_url']);
		$instagram_url = mysqli_real_escape_string($link, $_POST['instagram_url']);
		$linkedin_url = mysqli_real_escape_string($link, $_POST['linkedin_url']);
		$youtube_url = mysqli_real_escape_string($link, $_POST['youtube_url']);		
		$submit_query = "INSERT INTO home_page_social_networks (facebook_url, twitter_url, instagram_url, linkedin_url, youtube_url) VALUES ('$facebook_url', '$twitter_url', '$instagram_url', '$linkedin_url', '$youtube_url')";
		$submit_result = mysqli_query($link, $submit_query);
		if($submit_result){
			$alert_type = "success";
			$message = "Social networks have been successfully submitted!";
		}
		else{
			$alert_type = "danger";
			$message = "Social networks couldn't be submitted!";
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
		$facebook_url = mysqli_real_escape_string($link, $_POST['facebook_url']);
		$twitter_url = mysqli_real_escape_string($link, $_POST['twitter_url']);
		$instagram_url = mysqli_real_escape_string($link, $_POST['instagram_url']);
		$linkedin_url = mysqli_real_escape_string($link, $_POST['linkedin_url']);
		$youtube_url = mysqli_real_escape_string($link, $_POST['youtube_url']);		
		$update_query = "UPDATE home_page_social_networks SET facebook_url = '$facebook_url', twitter_url = '$twitter_url', instagram_url = '$instagram_url', linkedin_url = '$linkedin_url', youtube_url = '$youtube_url'";
		$update_result = mysqli_query($link, $update_query);
		if($update_result){
			$alert_type = "success";
			$message = "Social networks have been successfully updated!";
		}
		else{
			$alert_type = "danger";
			$message = "Social networks couldn't be updated!";
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
?>