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
			$(document).on('submit', '#change_password_form', function(e){
				e.preventDefault();
				var old_password = $("#old_password").val();
				var new_password = $("#new_password").val();
				$.ajax({
					url: "handlers/admin_change_password_handler.php",
					method: "POST",
					data: {old_password : old_password, new_password : new_password},
					dataType: "html",
					beforeSend: function() { 
						$("#change_password_button").html("Saving...");
						$("#change_password_button").prop("disabled", true);
					},
					success: function(data){
						$("#change_password_message").html(data);
						$("#change_password_form").trigger("reset");
						$("#change_password_button").prop("disabled", false);
						$("#change_password_button").html("Save");
					}
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
			<div id="change_password_message"></div>
			<div class="form_box">
				<div class="form_top">
					<div class="form_top_left">
						<h3>Change password</h3>
						<p>Enter your current and new password in order to change it:</p>
					</div>
					<div class="form_top_right">
						<i class="fas fa-unlock"></i>
					</div>
				</div>
				<div class="form_bottom">
					<form id="change_password_form" method="POST">
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="old_password" class="form-control old_password" id="old_password" placeholder="Current password...">
								<div class="input-group-append">
									<button class="btn btn-light old_password_button" type="button"><i class="fa fa-eye"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="new_password" class="form-control new_password" id="new_password" placeholder="New password...">
								<div class="input-group-append">
									<button class="btn btn-light new_password_button" type="button"><i class="fa fa-eye"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group">           
							<a class="btn btn-secondary" href="profile.php" role="button">Cancel</a>
							<span></span>
							<button class="btn btn-primary" id="change_password_button" type="submit">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(".old_password_button").on('click',function() {
		$("i", this).toggleClass("fa-eye-slash");
		var old_password = $("#old_password");
		if (old_password.attr('type') === 'password') {
			old_password.attr('type', 'text');
		} 
		else {
			old_password.attr('type', 'password');
		}
	});
	$(".new_password_button").on('click',function() {
		$("i", this).toggleClass("fa-eye-slash");
		var new_password = $("#new_password");
		if (new_password.attr('type') === 'password') {
			new_password.attr('type', 'text');
		} 
		else{
			new_password.attr('type', 'password');
		}
	});
</script>