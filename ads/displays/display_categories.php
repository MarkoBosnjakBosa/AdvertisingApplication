<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

$query = "SELECT * FROM categories";
$result = mysqli_query($link, $query);
$categories = array();
while ($fetch_result =  mysqli_fetch_assoc($result)) {
    $categories[] = $fetch_result;
}
$object['categories'] = $categories;
echo json_encode($object);
?>