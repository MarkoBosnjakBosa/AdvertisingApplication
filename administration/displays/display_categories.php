<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM categories ORDER BY id";
$result = mysqli_query($link, $query);
$counter = mysqli_num_rows($result);
$display_message = "";
if($counter == 0){
	$display_message = "<div style='margin-top: 10px; color: red; text-align: center;'><strong>There are no categories to be displayed!</strong></div>";
}
else{
	$count = 0;
	$display_message = "
		<table class='table'>
			<thead>
				<tr>
					<th scope='col'>#</th>
					<th scope='col'>Category</th>
					<th scope='col'>Publication time</th>
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
				<td>" . $fetch_result['title'] . "</td> 
				<td>" . $fetch_result['publication_time'] . "</td> 
				<td><button class='btn btn-danger' id='delete_category_button' value=" . $fetch_result["id"] . ">Delete</button></td>
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