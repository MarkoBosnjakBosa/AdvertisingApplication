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
	$query = "SELECT * FROM users WHERE id = '$id' AND administrator = 1";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$display_profile_picture = "";
	if($result){
		$display_profile_picture = "
			<img src='";
			if(isset($fetch_result['profile_picture']) && !empty($fetch_result['profile_picture'])){ 
				$display_profile_picture .= $fetch_result['profile_picture'] . "' alt='Avatar' class='rounded-circle' style='width: 100px; height:100px; border: 1px solid;'>"; 
			}
			else{ 
				$display_profile_picture .= "../default_pictures/avatar_picture.jpg' alt='Avatar' class='rounded-circle' style='width: 100px; height:100px; border: 1px solid;'>";
			}
	}
	echo $display_profile_picture;
}
?>