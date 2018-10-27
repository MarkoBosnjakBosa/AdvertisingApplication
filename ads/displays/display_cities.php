<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

$query = "SELECT * FROM cities";
$result = mysqli_query($link, $query);
$cities = array();
while ($fetch_result =  mysqli_fetch_assoc($result)) {
    $cities[] = $fetch_result;
}
$object['cities'] = $cities;
echo json_encode($object);
?>