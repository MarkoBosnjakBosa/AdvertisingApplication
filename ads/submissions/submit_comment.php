<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['content']) && !empty($_POST['content'])){
		$content = mysqli_real_escape_string($link, $_POST['content']);
		if(isset($_POST['username']) && !empty($_POST['username'])){
			$username = mysqli_real_escape_string($link, $_POST['username']);
			if(isset($_POST['ad_id']) && !empty($_POST['ad_id'])){
				$ad_id = mysqli_real_escape_string($link, $_POST['ad_id']);
				$mother_id = mysqli_real_escape_string($link, $_POST['mother_id']);
				date_default_timezone_set('Europe/Zagreb');
				$date = getdate();
				$publication_time = date('d.m.Y H:i:s');
				$query = "INSERT INTO comments (mother_id, content, username, ad_id, publication_time) VALUES ('$mother_id', '$content', '$username', '$ad_id', '$publication_time')";
				$result = mysqli_query($link, $query);
				if($result){
					$alert_type = "success";
					$message = "You have successfully submitted a comment!";
				}
				else{
					$alert_type = "danger";
					$message = "The comment couldn't be submitted!1";
				}
			}
			else{
				$alert_type = "danger";
				$message = "The comment couldn't be submitted!2";
			}
		}
		else{
			$alert_type = "danger";
			$message = "The comment couldn't be submitted!3";
		}
	}
	else{
		$alert_type = "danger";
		$message = "The comment couldn't be submitted!4";
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