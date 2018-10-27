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
				displayHomePageSocialNetworks();
				$(document).on('submit', '#home_page_social_networks_form', function(e){
					e.preventDefault();
					var facebook_url = $("#facebook_url").val();
					var twitter_url = $("#twitter_url").val();
					var instagram_url = $("#instagram_url").val();
					var linkedin_url = $("#linkedin_url").val();
					var youtube_url = $("#youtube_url").val();
					$.ajax({
						url: "handlers/home_page_social_networks_handler.php",
						method: "POST",
						data: {facebook_url : facebook_url, twitter_url : twitter_url, instagram_url : instagram_url, linkedin_url : linkedin_url, youtube_url : youtube_url},
						dataType: "html",
						success: function(data){
							$("#home_page_social_networks_message").html(data);
							displayHomePageSocialNetworks();
						}
					})
				})
				function displayHomePageSocialNetworks(){
					$.ajax({
						url: "displays/display_home_page_social_networks.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							$("#facebook_url").val(data.facebook_url);
							$("#twitter_url").val(data.twitter_url);
							$("#instagram_url").val(data.instagram_url);
							$("#linkedin_url").val(data.linkedin_url);
							$("#youtube_url").val(data.youtube_url);
						}
					})
				}
			})
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
					<a class="nav-link" href="home_page_pictures.php">Pictures</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_description.php">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_information.php">Information</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="home_page_social_networks.php">Social networks</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="jumbotron">
				<div class="home_page_social_networks">
					<div style="text-align: center">
						<h3>Home page social networks:</h3>
					</div>
					<hr/>
					<div id="home_page_social_networks_message"></div>
					<form id="home_page_social_networks_form" method="POST">
						<div class="form-group row">
							<label for="facebook_url" class="col-sm-2 col-form-label">Facebook url:</label>
							<div class="col-sm-10">
								<input type="url" class="form-control" name="facebook_url" id="facebook_url">
							</div>
						</div>
						<div class="form-group row">
							<label for="twitter_url" class="col-sm-2 col-form-label">Twitter url:</label>
							<div class="col-sm-10">
								<input type="url" class="form-control" name="twitter_url" id="twitter_url">
							</div>
						</div>
						<div class="form-group row">
							<label for="instagram_url" class="col-sm-2 col-form-label">Instagram url:</label>
							<div class="col-sm-10">
								<input type="url" class="form-control" name="instagram_url" id="instagram_url">
							</div>
						</div>
						<div class="form-group row">
							<label for="linkedin_url" class="col-sm-2 col-form-label">LinkedIn url:</label>
							<div class="col-sm-10">
								<input type="url" class="form-control" name="linkedin_url" id="linkedin_url">
							</div>
						</div>
						<div class="form-group row">
							<label for="youtube_url" class="col-sm-2 col-form-label">YouTube url:</label>
							<div class="col-sm-10">
								<input type="url" class="form-control" name="youtube_url" id="youtube_url">
							</div>
						</div>
						<div class="form-group-row">
							<div style="text-align: right">
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>