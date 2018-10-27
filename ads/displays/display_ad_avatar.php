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
	$query = "SELECT * FROM ads WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$display_message = "";
	if($result){
		$display_message = "
			<img src='";
			if(isset($fetch_result['ad_picture']) && !empty($fetch_result['ad_picture'])){ 
				$display_message .= $fetch_result['ad_picture'] . "' alt ='Ad avatar' class='img-fluid rounded' style='height: 180px; width:180px; border: 2px solid'>"; 
			}
			else{ 
				$display_message .= "../default_pictures/ad_picture.png' alt='Ad avatar' class='img-fluid rounded' style='height: 180px; width:180px; border: 2px solid'>";
			}
	}
	echo $display_message;
}
?>