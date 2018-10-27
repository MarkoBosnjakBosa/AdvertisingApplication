<?php   
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: ../admin_login.php');
}
$username = $_SESSION['admin_username'];

if(isset($_FILES['home_page_pictures']['name'][0])){  
    foreach($_FILES['home_page_pictures']['name'] as $key => $title){ 
		$extension = substr($title, strpos($title, '.') + 1);
		if(($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG")){				
			$location = "home_page_pictures/";
			$picture_caption = strstr($title, '.', true);
			$caption = ucfirst($picture_caption);
			$picture_title = $location.$title;
			move_uploaded_file($_FILES['home_page_pictures']['tmp_name'][$key], "../" . $picture_title);
			$picture_query = "INSERT INTO home_page_pictures (caption, title) VALUES ('$caption', '$picture_title')";
			$picture_result = mysqli_query($link, $picture_query);  
		}
	}  
}
?>  