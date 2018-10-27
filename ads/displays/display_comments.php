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
	$query = "SELECT * FROM comments WHERE mother_id = '0' AND ad_id = '$ad_id' ORDER BY id DESC";
	$result = mysqli_query($link, $query);
	$display_message = '';
	while ($fetch_result = mysqli_fetch_assoc($result)) {
		$display_message .= "
			<div class='card'>
			<div class='card-header'><div style='float: left'><b>" . $fetch_result["username"] . "</b></div><div style='text-align: right'>" . $fetch_result["publication_time"] . "</div></div>
			<div class='card-body'>" . $fetch_result["content"] . "</div>
			<div class='card-footer' align='right'><button type='button' class='btn btn-secondary reply' id='" . $fetch_result["id"] . "'>Reply</button></div></div>
		";
		$display_message .= displayComments($link, $fetch_result["id"]);
	}
	echo $display_message;
}
function displayComments($link, $mother_id = 0, $left_margin = 0){
	if(isset($_POST['ad_id']) && !empty($_POST['ad_id'])){
		$ad_id = mysqli_real_escape_string($link, $_POST['ad_id']);
		$comments_query = "SELECT * FROM comments WHERE mother_id = '" . $mother_id . "' AND ad_id = '$ad_id'";
		$comments_result = mysqli_query($link, $comments_query);
		$display_comments_message = "";	
		if($mother_id == 0){
			$left_margin = 0;
		}
		else{
			$left_margin = $left_margin + 60;
		}
		while ($fetch_comments_result = mysqli_fetch_assoc($comments_result)) {
			$display_comments_message .= "
				<div class='card' style='margin-left:" . $left_margin . "px'>
				<div class='card-header'><div style='float: left'><b>" . $fetch_comments_result["username"] . "</b></div><div style='text-align: right'>" . $fetch_comments_result["publication_time"] . "</div></div>
				<div class='card-body'>" . $fetch_comments_result["content"] . "</div>
				<div class='card-footer' align='right'><button type='button' class='btn btn-secondary reply' id='" . $fetch_comments_result["id"] . "'>Reply</button></div></div>
			";
			$display_comments_message .= displayComments($link, $fetch_comments_result["id"], $left_margin);
		}
		return $display_comments_message;
	}
}
?>