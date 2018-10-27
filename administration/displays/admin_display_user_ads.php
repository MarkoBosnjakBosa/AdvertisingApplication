<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['username']) && !empty($_POST['username'])){
		$username = mysqli_real_escape_string($link, $_POST['username']);
		$username_query = "SELECT * FROM users WHERE username = '$username'";
		$username_result = mysqli_query($link, $username_query);
		$username_counter = mysqli_num_rows($username_result);
		if($username_counter == 1){
			$username_fetch_result = mysqli_fetch_assoc($username_result);
			$username_id = $username_fetch_result['id'];
			$query = "SELECT * FROM ads WHERE user_id = '$username_id' ORDER BY id DESC";
			$result = mysqli_query($link, $query);
			$counter = mysqli_num_rows($result);
			if($counter == 0){
				echo "
					<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><strong>There are no ads to be displayed!</strong> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button></div>
				";
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
						<tr id='row" . $fetch_result['id'] . "'> 
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
				echo $display_message;
			}
		}
		else{
			echo "
				<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><strong>Username doesn't exist!</strong> 
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button></div>
			";
		}
		
	}
	else{
		echo "
			<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><strong>Enter a username!</strong> 
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button></div>
		";
	}
}
?>