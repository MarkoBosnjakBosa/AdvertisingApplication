<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = mysqli_real_escape_string($link, $_POST['id']);
	$query = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$username = $fetch_result['username'];
	$email = $fetch_result['email'];
	$first_name = $fetch_result['first_name'];
	$last_name = $fetch_result['last_name'];
	$city = $fetch_result['city'];
	$telephone = $fetch_result['telephone'];
	$object = array(
		'username' => $username,
		'email' => $email,
		'firstname' => $first_name,
		'lastname' => $last_name,
		'city' => $city,
		'telephone' => $telephone
	);
	$data = json_encode($object);
	echo $data;
}
?>