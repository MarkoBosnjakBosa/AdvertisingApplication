<?php
require_once('../../connect.php');
require_once('../../recaptcha.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../../login.php');
}
$username = $_SESSION['username'];

$secret = "6Let8k8UAAAAAAAK5wgoerEDXhtBS1RU7XJ-eZD7";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if(isset($_POST) && !empty($_POST)){
	if($_POST['recaptcha']){
		$response = $reCaptcha->verifyResponse(
			$_SERVER['REMOTE_ADDR'],
			$_POST['recaptcha']
		);
	}
	if($response != null && $response->success){
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$title = mysqli_real_escape_string($link, $_POST['title']);
			if(isset($_POST['description']) && !empty($_POST['description'])){
				$description = mysqli_real_escape_string($link, $_POST['description']);
				if(isset($_POST['price']) && !empty($_POST['price'])){
					$price = mysqli_real_escape_string($link, $_POST['price']);
					if(isset($_POST['city']) && !empty($_POST['city'])){
						$city = mysqli_real_escape_string($link, $_POST['city']);
						if(isset($_POST['condition']) && !empty($_POST['condition'])){
							$condition = mysqli_real_escape_string($link, $_POST['condition']);
							if(isset($_POST['category']) && !empty($_POST['category'])){
								$category = mysqli_real_escape_string($link, $_POST['category']);
								$user_id = mysqli_real_escape_string($link, $_POST['user_id']);
								date_default_timezone_set('Europe/Zagreb');
								$date = getdate();
								$publication_time = date('d.m.Y H:i:s');
								
								$name = $_FILES['ad_picture']['name'];
								$size = $_FILES['ad_picture']['size'];
								$type = $_FILES['ad_picture']['type'];
								$tmp_name = $_FILES['ad_picture']['tmp_name'];
								$extension = substr($name, strpos($name, '.') + 1);
								if(isset($name) && !empty($name)){
									if(($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG")){
										$location = "ads_avatars/";
										$ad_avatar_name = $location.$name;
										move_uploaded_file($tmp_name, "../".$ad_avatar_name);		
										$query = "INSERT INTO ads (`title`, `description`, `price`, `city`, `condition`, `category`, `ad_picture`, `user_id`, `publication_time`) VALUES ('$title', '$description', '$price', '$city', '$condition', '$category', '$ad_avatar_name', '$user_id', '$publication_time')";
										$result = mysqli_query($link, $query);
										$ad_id = mysqli_insert_id($link);
									}
								}
								else{
									$alert_type = "danger";
									$message = "Select a file!";
								}
								
								if(isset($_FILES['pictures']['name'][0])){  
									foreach ($_FILES['pictures']['name'] as $key => $title){
										$pictures_extension = substr($title, strpos($title, '.') + 1);
										if(($pictures_extension == "jpg" || $pictures_extension == "JPG" || $pictures_extension == "jpeg" || $pictures_extension == "JPEG" || $pictures_extension == "png" || $pictures_extension == "PNG")){
											$picture_location = "ads_pictures/";
											$picture_title = $picture_location.$title;
											move_uploaded_file($_FILES['pictures']['tmp_name'][$key], '../' . $picture_title);
											$picture_query = "INSERT INTO ads_pictures (title, ad_id) VALUES ('$picture_title', '$ad_id')";
											$picture_result = mysqli_query($link, $picture_query);
										}
									}
								}
								else{
									$alert_type = "danger";
									$message = "Select one or more files!";
								}
								
								if($result && $picture_result){
									$alert_type = "success";
									$message = "You have successfully created the ad!";
								}
								else{
									$alert_type = "danger";
									$message = "You couldn't create the ad!";
								}
							}
							else{
								$alert_type = "danger";
								$message = "Select a category!";
							}
						}
						else{
							$alert_type = "danger";
							$message = "Check a condition!";
						}
					}
					else{
						$alert_type = "danger";
						$message = "Select a city!";
					}
				}
				else{
					$alert_type = "danger";
					$message = "Enter a price!";
				}
			}
			else{
				$alert_type = "danger";
				$message = "Enter a description!";
			}
		}
		else{
			$alert_type = "danger";
			$message = "Enter a title!";
		}
	}
	else{
		$alert_type = "danger";
		$alert_message = "ReCaptcha must be confirmed!";
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