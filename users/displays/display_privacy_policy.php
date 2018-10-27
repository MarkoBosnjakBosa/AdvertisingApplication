<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$privacy_policy = $fetch_result['privacy_policy'];
$object = array(
	'privacy_policy' => $privacy_policy
);
$data = json_encode($object);
echo $data;
?>