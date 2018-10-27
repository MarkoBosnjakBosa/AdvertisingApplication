<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_pictures";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
$display_message = "";
if($counter == 0){
	$display_message = "<div style='margin-top: 10px; color:red; text-align: center'><strong>There are no pictures to be displayed!</strong></div>";
}
else{
	while ($fetch_result = mysqli_fetch_assoc($result)){
		$display_message .= "
			<div style='float: left; margin-right: 5px; margin-bottom: 5px; height: 202px; width: 234px;'>
				<img src='" . $fetch_result['title'] . "' style='width:200px; height:200px; border: 2px solid; border-radius: 5px;'>
				<i class='fa fa-times-circle fa-2x delete_my_picture_icon' id='" . $fetch_result['id'] . "'></i>
			</div>
		";
	}
}
echo $display_message;
?>