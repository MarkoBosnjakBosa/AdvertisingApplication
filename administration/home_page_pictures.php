<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: admin_login.php');
}
$username = $_SESSION['admin_username'];
?>
<html>
	<head>
		<title>Small Ads</title>
		<meta name="description" content="Online application for advertisement">
		<meta name="author" content="Marko Bošnjak">
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<link rel="stylesheet" type="text/css" href="../style.css?<?php echo date('d-m-Y H:i:s');?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				displayHomePagePictures();
				$('.drag_area').on('dragover', function(){  
					$(this).addClass('drag_area_over');  
					return false;  
				});  
				$('.drag_area').on('dragleave', function(){  
					$(this).removeClass('drag_area_over');  
					return false;  
				});  
				$('.drag_area').on('drop', function(e){  
					e.preventDefault();  
					$(this).removeClass('drag_area_over');  
					var formData = new FormData();  
					var pictures = e.originalEvent.dataTransfer.files;  
					for(var x = 0; x < pictures.length; x++){  
						formData.append("home_page_pictures[]", pictures[x]);  
					}
					$.ajax({  
						url: "submissions/submit_home_page_pictures.php",
						method: "POST",  
						data: formData,  
						contentType: false,  
						cache: false,  
						processData: false,  
						success: function(data){  
							displayHomePagePictures(); 
						}  
					})				
				}); 
				function displayHomePagePictures(){
					$.ajax({
						url: "displays/display_home_page_pictures.php",
						method: "GET",
						dataType: "html",
						success: function(data){
							$("#display_home_page_pictures").html(data);
						}
					})
				}
				$(document).on('click', '.delete_my_picture_icon', function (){
					var id = $(this).attr('id');
					$.ajax({
						url: "deletions/delete_home_page_picture.php",
						method: "POST",
						data: {id : id},
						dataType: "html",
						success: function(data){
							$("#delete_home_page_picture_message").html(data);
							displayHomePagePictures();
						}
					})
				})
			});  
		</script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="../home.php"><i class="fa fa-home fa-2x"></i></a>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="../home.php">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="ads_list.php">Ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="users_list.php">Users</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="administrators_list.php">Admins</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="cities.php">Cities</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="categories.php">Categories</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="home_page_pictures.php">Home page</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="admin_privacy_policy.php">Privacy policy</a>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $username; ?><span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="admin_profile.php">Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="admin_change_password.php">Change password</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="admin_logout.php">Log out</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<ul class="nav nav-tabs justify-content-center">
				<li class="nav-item">
					<a class="nav-link active" href="home_page_pictures.php">Pictures</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_description.php">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_information.php">Information</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_social_networks.php">Social networks</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="jumbotron" id="home_page_pictures_jumbotron">
				<div class="drop_title">
					<h5>Drag and drop home pictures here</h5>
				</div> 
				<div class="drag_area">  
					<div class="drag_text">
						<i class="fas fa-upload fa-4x"></i>
					</div>
				</div>
			</div>
			<hr/>
		</div>
		<div class="container">
			<div id="delete_home_page_picture_message"></div>
			<div id="display_home_page_pictures"></div>
		</div>
	</body>
</html>