<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['id']) && !empty($_POST['id'])){
		$id = mysqli_real_escape_string($link, $_POST['id']);
		if(isset($_FILES) && !empty($_FILES)){
			$name = $_FILES['ad_picture']['name'];
			$size = $_FILES['ad_picture']['size'];
			$type = $_FILES['ad_picture']['type'];
			$tmp_name = $_FILES['ad_picture']['tmp_name'];
			$extension = substr($name, strpos($name, '.') + 1);
			if(isset($name) && !empty($name)){
				if(($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG")){
					$location = "ads_avatars/";
					$ad_avatar_name = $location.$name;
					$query = "SELECT * FROM ads WHERE id = '$id'";
					$result = mysqli_query($link, $query);
					$fetch_result = mysqli_fetch_assoc($result);
					$title = $fetch_result['ad_picture'];
					if($title == ""){
						move_uploaded_file($tmp_name, "../".$ad_avatar_name);
						$update_picture = "UPDATE ads SET ad_picture = '$ad_avatar_name' WHERE id = '$id'";
						$update_picture_result = mysqli_query($link, $update_picture);
						if($update_picture_result){
							$alert_type = "success";
							$message = "The picture has been successfully updated!";
						}
						else{
							$alert_type = "danger";
							$message = "The picture couldn't be updated!";
						}
					}
					else{
						$alert_type = "danger";
						$message = "You must first delete the existing picture in order to insert a new one!";
					}
				}	
				else{
					$alert_type = "danger";
					$message = "The picture must have a .jpg, .jpeg or .png extension!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "Select a file!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "The picture couldn't be updated!";
		}
	}
	else{
		$alert_type = "danger";
		$message = "The picture couldn't be updated!";
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
?>