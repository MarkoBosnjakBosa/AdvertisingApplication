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
								$update_query = "UPDATE ads SET `title` = '$title', `description` = '$description', `price` = ' $price', `city` = '$city', `condition` = '$condition', `category` = '$category' WHERE id = '$id'";
								$update_result = mysqli_query($link, $update_query);
								if($update_result){
									$alert_type = "success";
									$message = "The ad has been successfully updated!";
								}
								else{
									$alert_type = "danger";
									$message = "The ad couldn't be updated!";
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
		$message = "The ad couldn't be updated!";
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