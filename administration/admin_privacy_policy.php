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
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=szn58arvq7tawdedebnwrou079c3h3alu3xpn2m8t8sbxiu0"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				displayPrivacyPolicy();
				$(document).on('submit', '#privacy_policy_form', function(e){
					e.preventDefault();
					var privacy_policy = $("#privacy_policy").val();
					$.ajax({
						url: "handlers/admin_privacy_policy_handler.php",
						method: "POST",
						data: {privacy_policy : privacy_policy},
						dataType: "html",
						success: function(data){
							$("#privacy_policy_message").html(data);
							displayPrivacyPolicy();
						}
					})
				})
				function displayPrivacyPolicy(){
					$.ajax({
						url: "displays/admin_display_privacy_policy.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							$("#privacy_policy").val(data.privacy_policy);
						}
					})
				}
				tinymce.init({
					selector: '#privacy_policy',
					plugins: "textcolor fullscreen link insertdatetime lists table preview",
					toolbar: "forecolor backcolor fontselect link insertdatetime numlist bullist table fullscreen preview",
					menubar: "file edit view insert format table",
					default_link_target: "_blank",
					branding: false,
					setup: function(editor){
						editor.on("change", function(e){
							editor.save();
						});
					}
				});
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
						<a class="nav-link" href="privacy_policy.php">Privacy policy</a>
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
			<div class="jumbotron">
				<div class="admin_privacy_policy">
					<div style="text-align: center">
						<h3>Privacy policy:</h3>
					</div>
					<hr/>
					<div id="privacy_policy_message"></div>
					<form id="privacy_policy_form" method="POST">
						<div class="form-group row">
							<label for="description" class="col-sm-2 col-form-label">Privacy policy</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="privacy_policy" id="privacy_policy" rows="5" required></textarea>
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