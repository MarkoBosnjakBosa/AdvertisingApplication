<?php
require_once('connect.php');
mysqli_set_charset($link,'utf-8');

if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$query = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($link, $query);
	$counter = mysqli_num_rows($result);
	$display_message = "";
	if($counter > 0){
		$display_message = "<div style='margin-top: 10px; color: red; text-align: center;'><i class='fa fa-times'></i> Email address is already taken!</div>";
	}
	else{
		$display_message = "<div style='margin-top: 10px; color: green; text-align: center;'><i class='fa fa-check'></i> Email address is available!</div>";
	}
	echo $display_message;
}	
?>