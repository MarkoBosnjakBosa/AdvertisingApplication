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
	$query = "SELECT * FROM ads WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$title = $fetch_result['title'];
	$description = $fetch_result['description'];
	$price = $fetch_result['price'];
	$city = $fetch_result['city'];
	$condition = $fetch_result['condition'];
	$category = $fetch_result['category'];
	$object = array(
		'title' => $title,
		'description' => $description,
		'price' => $price,
		'city' => $city,
		'condition' => $condition,
		'category' => $category
	);
	$data = json_encode($object);
	echo $data;
}
?>