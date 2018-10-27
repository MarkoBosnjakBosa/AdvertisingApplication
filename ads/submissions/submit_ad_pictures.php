<?php   
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST['ad_id']) && !empty($_POST['ad_id'])){
	$ad_id = mysqli_real_escape_string($link, $_POST['ad_id']);
	if(isset($_FILES['pictures']['name'][0])){
		foreach($_FILES['pictures']['name'] as $key => $title){
			$extension = substr($title, strpos($title, '.') + 1);
			if(($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG")){	
				$location = "ads_pictures/";
				$picture_title = $location.$title;
				move_uploaded_file($_FILES['pictures']['tmp_name'][$key], "../".$picture_title);
				$picture_query = "INSERT INTO ads_pictures (title, ad_id) VALUES ('$picture_title', '$ad_id')";
				$picture_result = mysqli_query($link, $picture_query);
			}
		}  
	}
}
?>  