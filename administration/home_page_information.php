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
				displayHomePageInformation();
				$(document).on('submit', '#home_page_information_form', function(e){
					e.preventDefault();
					var name = $("#name").val();
					var address = $("#address").val();
					var city = $("#city").val();
					var country = $("#country").val();
					var email = $("#email").val();
					var fax = $("#fax").val();
					var telephone = $("#telephone").val();
					$.ajax({
						url: "handlers/home_page_information_handler.php",
						method: "POST",
						data: {name : name, address : address, city : city, country : country, email : email, fax : fax, telephone : telephone},
						dataType: "html",
						success: function(data){
							$("#home_page_information_message").html(data);
							displayHomePageInformation();
						}
					})
				})
				function displayHomePageInformation(){
					$.ajax({
						url: "displays/display_home_page_information.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							$("#name").val(data.name);
							$("#address").val(data.address);
							$("#city").val(data.city);
							$("#country").val(data.country);
							$("#email").val(data.email);
							$("#fax").val(data.fax);
							$("#telephone").val(data.telephone);
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
					<a class="nav-link active" href="home_page_information.php">Information</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="home_page_social_networks.php">Social networks</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="jumbotron">
				<div class="home_page_information">
					<div style="text-align: center">
						<h3>Home page information:</h3>
					</div>
					<hr/>
					<div id="home_page_information_message"></div>
					<form id="home_page_information_form" method="POST">
						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label">Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="name" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="address" class="col-sm-2 col-form-label">Address:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="address" id="address" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="city" class="col-sm-2 col-form-label">City:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="city" id="city" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="country" class="col-sm-2 col-form-label">Country:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="country" id="country" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="email" class="col-sm-2 col-form-label">Email:</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" name="email" id="email" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="fax" class="col-sm-2 col-form-label">Fax:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="fax" id="fax" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="telephone" class="col-sm-2 col-form-label">Telephone:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="telephone" id="telephone" required>
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