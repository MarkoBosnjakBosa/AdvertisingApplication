<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

$user_query = "SELECT * FROM users WHERE username = '$username'";
$user_result = mysqli_query($link, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

$query = "SELECT * FROM ads WHERE user_id = '$user_id' ORDER BY publication_time DESC";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
$display_message = "";
if($counter == 0){
	$display_message = "<div style='margin-top: 10px; color:red; text-align: center'><strong>There are no ads to be displayed!</strong></div>";
}
else{
	while ($fetch_result = mysqli_fetch_assoc($result)){
		$display_message .= "
			<div class='jumbotron' id='my_ads_jumbotron'>
				<div class='row'>
					<div class='col-sm-2'>
						<img src='"; 
						if(isset($fetch_result['ad_picture']) && !empty($fetch_result['ad_picture'])){ 
							$display_message .= $fetch_result['ad_picture'] . "' alt ='Ad picture' class='img-fluid rounded' style='width: 180px; height: 180px; border: 1px solid;'>"; 
						}
						else{ 
							$display_message .= "../default_pictures/ad_picture.png' alt ='Ad picture' class='img-fluid rounded' style='width: 180px; height: 180px; border: 1px solid;'>";
						}
						$display_message .= "
					</div>
					<div class='col-sm-10'>
						<h3>" . $fetch_result['title'] . "</h3>
						<hr>
						<div class='row'>
							<div class='col-sm-3'>
								<p>Category: <b>" . $fetch_result['category'] . "</b></p>
								<p>Condition: <b>" . $fetch_result['condition'] . "</b></p>
								<p>Price: <b>" . $fetch_result['price'] . " €</b></p>
							</div>
							<div class='col-sm-3'>
								<p>City: <b>" . $fetch_result['city'] . "</b></p>
								<p><b>" . $fetch_result['publication_time'] . "</b></p>
							</div>
							<div class='col-sm-6'>									
								<p><a class='btn btn-info' href='edit_ad.php?id=" . $fetch_result['id'] . "' role='button'>Edit</a>
								<span></span>
								<button class='btn btn-danger' id='delete_ad_button' value=" . $fetch_result["id"] . ">Delete</button>
								<span></span>
								<a class='btn btn-primary' href='view_my_ad.php?id=" . $fetch_result['id'] . "' role='button'>Detailed</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		";
	}
}
echo $display_message;
?>