<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM privacy_policy";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$privacy_policy = $fetch_result['privacy_policy'];
$object = array(
    'privacy_policy' => $privacy_policy
);
$data = json_encode($object);
echo $data;
?>