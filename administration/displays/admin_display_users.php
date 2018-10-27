<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];
					
$query = "SELECT * FROM users WHERE administrator = 0 ORDER BY id DESC";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
$display_message = "";
if($counter == 0){
	$display_message = "<div style='margin-top: 10px; color: red; text-align: center;'><strong>There are no users to be displayed!</strong></div>";
}
else{
	$count = 0;
	$display_message = "
		<table class='table'>
			<thead>
				<tr>
					<th scope='col'>#</th>
					<th scope='col'>Username</th>
					<th scope='col'>Email</th>
					<th scope='col'>First name</th>
					<th scope='col'>Last name</th>
					<th scope='col'>City</th>
					<th scope='col'>Telephone</th>
					<th scope='col'>Registration time</th>
					<th scope='col'>Action</th>
				</tr>
			</thead>
			<tbody>
	";
	while ($fetch_result = mysqli_fetch_assoc($result)){
		$count++;
		$display_message .= "
			<tr> 
				<th scope='row'>" . $count . "</th> 
				<td>" . $fetch_result['username'] . "</td> 
				<td>" . $fetch_result['email'] . "</td> 
				<td>" . $fetch_result['first_name'] . "</td> 
				<td>" . $fetch_result['last_name'] . "</td> 
				<td>" . $fetch_result['city'] . "</td> 
				<td>" . $fetch_result['telephone'] . "</td>
				<td>" . $fetch_result['registration_time'] . "</td> 
				<td><button class='btn btn-danger' id='delete_user_button' value=" . $fetch_result["id"] . ">Delete</button></td>
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