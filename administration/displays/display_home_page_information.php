<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_information";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$name = $fetch_result['name'];
$address = $fetch_result['address'];
$city = $fetch_result['city'];
$country = $fetch_result['country'];
$email = $fetch_result['email'];
$fax = $fetch_result['fax'];
$telephone = $fetch_result['telephone'];
$object = array(
	'name' => $name,
    'address' => $address,
	'city' => $city,
    'country' => $country,
	'email' => $email,
    'fax' => $fax,
	'telephone' => $telephone
);
$data = json_encode($object);
echo $data;
?>