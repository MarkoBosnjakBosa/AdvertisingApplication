<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM home_page_social_networks";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$facebook_url = $fetch_result['facebook_url'];
$twitter_url = $fetch_result['twitter_url'];
$instagram_url = $fetch_result['instagram_url'];
$linkedin_url = $fetch_result['linkedin_url'];
$youtube_url = $fetch_result['youtube_url'];
$object = array(
	'facebook_url' => $facebook_url,
    'twitter_url' => $twitter_url,
	'instagram_url' => $instagram_url,
    'linkedin_url' => $linkedin_url,
	'youtube_url' => $youtube_url
);
$data = json_encode($object);
echo $data;
?>