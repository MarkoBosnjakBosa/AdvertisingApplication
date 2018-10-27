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
	$query = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$display_message = "";
	if($result){
		$display_message = "
			<img src='";
			if(isset($fetch_result['profile_picture']) && !empty($fetch_result['profile_picture'])){ 
				$display_message .= $fetch_result['profile_picture'] . "' alt='Avatar' class='rounded-circle' style='width: 100px; height:100px; border: 1px solid;'>"; 
			}
			else{ 
				$display_message .= "../default_pictures/avatar_picture.jpg' alt='Avatar' class='rounded-circle' style='width: 100px; height:100px; border: 1px solid;'>";
			}
	}
	echo $display_message;
}
?>