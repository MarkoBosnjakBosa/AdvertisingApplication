<?php
require_once('../connect.php');
require_once('../recaptcha.php');
mysqli_set_charset($link,'utf-8');
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('submit', '#administrator_registration_form', function(e){
					e.preventDefault();
					var recaptcha = grecaptcha.getResponse();
					var username = $("#username").val();
					var email = $("#email").val();
					var password = $("#password").val();
					var first_name = $("#first_name").val();
					var last_name = $("#last_name").val();
					var city = $("#city").val();
					var telephone = $("#telephone").val();
					$.ajax({
						url: "handlers/administrator_registration_handler.php",
						method: "POST",
						data: {recaptcha : recaptcha, username : username, email : email, password : password, first_name : first_name, last_name : last_name, city : city, telephone : telephone},
						dataType: "html",
						beforeSend: function(){ 
							$("#administrator_registration_button").html("Saving...");
							$("#administrator_registration_button").prop("disabled", true);
						},
						success: function(data){
							$("#administrator_registration_message").html(data);
							$("#administrator_registration_form").trigger("reset");
							$("#username_status").hide();
							$("#email_status").hide();
							$("#administrator_registration_button").prop("disabled", false);
							$("#administrator_registration_button").html("Submit");
							$(window).scrollTop(0);
						}
					})
				})
				$(document).on('keyup', '#username', function () {
					var username = $("#username").val();
					$.ajax({
						url: "../check_username.php",
						type: "POST",
						data: {username : username},
						dataType: "html",
						success: function(data){
							$("#username_status").html(data);
						}
					})
				})
				$(document).on('keyup', '#email', function () {
					var email = $("#email").val();
					$.ajax({
						url: "../check_email.php",
						type: "POST",
						data: {email : email},
						dataType: "html",
						success: function(data){
							$("#email_status").html(data);
						}
					})
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
					<a class="nav-link" href="administrators_list.php">Administrators</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="register_administrator.php">Registration</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div id="administrator_registration_message"></div>
			<div class="form_box">
				<div class="form_top">
					<div class="form_top_left">
						<h3>Register administrator</h3>
						<p>Fill in the form below to register a new administrator:</p>
					</div>
					<div class="form_top_right">
						<i class="fa fa-pencil-alt"></i>
					</div>
				</div>
				<div class="form_bottom">
					<form id="administrator_registration_form" method="POST">
						<div class="form-group">
							<input type="text" name="username" class="form-control username_registration" id="username" placeholder="Username..." required>
						<span id="username_status" style="text-align: center"></span>
						</div>
						<div class="form-group">
							<input type="email" name="email" class="form-control email_registration" id="email" placeholder="Email..." required>
						<span id="email_status" style="text-align: center"></span>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="password" class="form-control password_registration" id="password" placeholder="Password..." required>
								<div class="input-group-append">
									<button class="btn btn-light password_button" type="button"><i class="fa fa-eye"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="text" name="first_name" class="form-control first_name_registration" id="first_name" placeholder="First name..." required>
						</div>
						<div class="form-group">
							<input type="text" name="last_name" class="form-control last_name_registration" id="last_name" placeholder="Last name..." required>
						</div>
						<div class="form-group">
							<input type="text" name="city" class="form-control city_registration" id="city" placeholder="City..." required>
						</div>
						<div class="form-group">
							<input type="text" name="telephone" class="form-control telephone_registration" id="telephone" placeholder="Telephone..." required>
						</div>
						<div class="recaptcha">
							<div class="g-recaptcha" data-sitekey="6Let8k8UAAAAAFM_ifPQxYY4hGMLx4D5sKCTWUTP"></div>
						</div>
						<div class="form-row">
							<div class="col-sm">
								<button class="btn btn-lg btn-danger btn-block" type="reset">Reset</button>
							</div>
							<div class="col-sm">
								<button class="btn btn-lg btn-primary btn-block" id="administrator_registration_button" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).on('click', ".password_button", function(){
		$("i", this).toggleClass("fa-eye-slash");
		var pass = $("#password");
		if (pass.attr('type') === 'password'){
			pass.attr('type', 'text');
		} 
		else {
			pass.attr('type', 'password');
		}	
	})
</script>