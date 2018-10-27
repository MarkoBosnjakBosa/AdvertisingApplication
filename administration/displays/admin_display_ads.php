<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];
					
$query = "SELECT * FROM ads ORDER BY id DESC";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
$display_message = "";
if($counter == 0){
	$display_message = "<div style='margin-top: 10px; color: red; text-align: center;'><strong>There are no ads to be displayed!</strong></div>";
}
else{
	$count = 0;
	$display_message = "
		<table class='table'>
			<thead>
				<tr>
					<th scope='col'>#</th>
					<th scope='col'>Title</th>
					<th scope='col'>Description</th>
					<th scope='col'>Price</th>
					<th scope='col'>User</th>
					<th scope='col'>Action</th>
				</tr>
			</thead>
			<tbody>
	";
	while ($fetch_result = mysqli_fetch_assoc($result)){
		$user_id = $fetch_result['user_id'];
		$user_query = "SELECT * FROM users WHERE id = '$user_id'";
		$user_fetch_result = mysqli_query($link, $user_query);
		$user = mysqli_fetch_assoc($user_fetch_result);
		$count++;
		$display_message .= "
			<tr> 
				<th scope='row'>" . $count . "</th> 
				<td>" . $fetch_result['title'] . "</td> 
				<td>" . $fetch_result['description'] . "</td> 
				<td>" . $fetch_result['price'] . "</td> 
				<td>" . $user['username'] . "</td>
				<td><a class='btn btn-primary' href='../ads/view_ad.php?id=" . $fetch_result['id'] . "' role='button'>Detailed</a>
					<span></span>
					<button class='btn btn-danger' id='delete_ad_button' value=" . $fetch_result["id"] . ">Delete</button></td>
			</tr> 
		";
	}
	$display_message .= "
			</tbody>
		</table>
	";
}
echo $display_message;
?>