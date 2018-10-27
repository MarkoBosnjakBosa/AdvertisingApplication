<?php
require_once('connect.php');
mysqli_set_charset($link,'utf-8');

if(isset($_POST['username']) && !empty($_POST['username'])){
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($link, $query);
	$counter = mysqli_num_rows($result);
	$display_message = "";
	if($counter > 0){
		$display_message = "<div style='margin-top: 10px; color: red; text-align: center;'><i class='fa fa-times'></i> Username is already taken!</div>";
	}
	else{
		$display_message = "<div style='margin-top: 10px; color: green; text-align: center;'><i class='fa fa-check'></i> Username is available!</div>";
	}
	echo $display_message;
}
?>