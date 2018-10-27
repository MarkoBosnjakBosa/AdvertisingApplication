<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_description";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$description = $fetch_result['description'];
$object = array(
    'description' => $description
);
$data = json_encode($object);
echo $data;
?>