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
				$(document).on('submit', '#search_user_ads_form', function(e){
					e.preventDefault();
					var username = $("#username").val();
					$.ajax({
						url: "displays/admin_display_user_ads.php",
						method: "POST",
						data: {username : username},
						dataType: "html",
						success: function(data){
							$("#display_user_ads").html(data);
							$("#search_user_ads_form").trigger("reset");							
						}
					})
				})
				$(document).on('click', '#delete_ad_button', function(){
					var id = $(this).val();
					$.ajax({
						url: "deletions/admin_delete_user_ad.php",
						method: "POST",
						data: {id : id},
						dataType: "json",
						success: function(data){
							var alert_type = data.alert_type;
							var message = data.message;
							if(alert_type == "success"){
								$("#alert_success_div").html("<strong>" + message + "</strong><button type='button' class='close alert_close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
								$("#row" + id).remove();
								$("#alert_success_div").show();
							}
							else{
								$("#alert_danger_div").html("<strong>" + message + "</strong><button type='button' class='close alert_close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
								$("#alert_danger_div").show();
							}
						}
					})
				})
				$(document).on('click', '.alert_close', function(){
					$(this).parent().hide();
				})
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
					<a class="nav-link" href="ads_list.php">All ads</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="user_ads_list.php">Ads by user</a>
				</li>
			</ul>
		</div>
		<div class="container" id="search_user_ads_container">
			<form id="search_user_ads_form" method="POST">
				<div class="form-group row text-center">
					<label for="username" class="col-sm-2 col-form-label">Enter a username:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="username" id="username">
					</div>
					<div class="col-sm-2">
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</div>
			</form>
			<hr/>
				<div class="alert alert-success alert-dismissible fade show text-center" id="alert_success_div" role="alert" style="display: none"></div>
				<div class="alert alert-danger alert-dismissible fade show text-center" id="alert_danger_div" role="alert" style="display: none"></div>
			<div id="display_user_ads"></div>
		</div>
	</body>
</html>