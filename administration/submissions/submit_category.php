<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['category']) && !empty($_POST['category'])){
		$title = mysqli_real_escape_string($link, $_POST['category']);
		$check_category = "SELECT * FROM categories WHERE title = '$title'";
		$category_result = mysqli_query($link, $check_category);
		$category_counter = mysqli_num_rows($category_result);
		if($category_counter > 0){
			$alert_type = "danger";
			$message = "The category already exists!";
		}
		else{
			date_default_timezone_set('Europe/Zagreb');
			$date = getdate();
			$publication_time = date('d.m.Y H:i:s');
			$table_row = "INSERT INTO categories (title, publication_time) VALUES ('$title', '$publication_time')";
			$result = mysqli_query($link, $table_row);
			if($result){
				$alert_type = "success";
				$message = "The category has been successfully submitted!";
			}
			else{
				$alert_type = "danger";
				$message = "The category couldn't be submitted!";
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