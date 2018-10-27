<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST['ad_id']) && !empty($_POST['ad_id'])){
	$ad_id = mysqli_real_escape_string($link, $_POST['ad_id']);
	$query = "SELECT * FROM ads_pictures WHERE ad_id = '$ad_id'";
	$result = mysqli_query($link, $query);
	$counter = mysqli_num_rows($result);
	$display_message = "";
	if($counter == 0){
		$display_message = "<div style='margin-top: 10px; color:red; text-align: center'><strong>There are no pictures to be displayed!</strong></div>";
	}
	else{
		while ($fetch_result = mysqli_fetch_assoc($result)) {
			$display_message .= "
				<div style='float: left; margin-right: 5px; margin-bottom: 5px; height: 202px; width: 234px;'>
					<img src='" . $fetch_result['title'] . "' style='width: 200px; height: 200px; border: 1px solid; border-radius: 5px;'>
					<i class='fa fa-times-circle fa-2x delete_my_picture_icon' id='" . $fetch_result['id'] . "'></i>
				</div>
			";
		}
	}
	echo $display_message;
}
?>