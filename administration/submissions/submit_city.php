<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['city']) && !empty($_POST['city'])){
		$title = mysqli_real_escape_string($link, $_POST['city']);
		$check_city = "SELECT * FROM cities WHERE title = '$title'";
		$city_result = mysqli_query($link, $check_city);
		$city_counter = mysqli_num_rows($city_result);
		if($city_counter > 0){
			$alert_type = "danger";
			$message = "The city already exists!";
		}
		else{
			date_default_timezone_set('Europe/Zagreb');
			$date = getdate();
			$publication_time = date('d.m.Y H:i:s');
			$table_row = "INSERT INTO cities (title, publication_time) VALUES ('$title', '$publication_time')";
			$result = mysqli_query($link, $table_row);
			if($result){
				$alert_type = "success";
				$message = "The city has been successfully submitted!";
			}
			else{
				$alert_type = "danger";
				$message = "The city couldn't be submitted!";
			}
		}
	}
	else{
		$alert_type = "danger";
		$message = "Enter a city!";
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