<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['admin_username']) && empty($_SESSION['admin_username'])){
	header('location: admin_login.php');
}
$username = $_SESSION['admin_username'];

$query = "SELECT * FROM users WHERE username = '$username' AND administrator = 1";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
$id = $fetch_result['id'];
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
				displayProfilePicture();
				displayEditProfileInformation();
				$(document).on('submit', '#change_profile_picture_form', function(e){
					e.preventDefault();
					var formData = new FormData($(this)[0]);
					formData.append("user_id", "<?php echo $id;?>");
					$.ajax({
						url: "submissions/admin_submit_profile_picture.php",
						method: "POST",
						data: formData,  
						contentType: false, 
						processData: false,
						success: function(data){
							$("#submit_profile_picture_message").html(data);
							displayProfilePicture();
							$("#profile_picture").val("");
							$("#profile_picture_preview").empty();
						}
					})
				})
				$(document).on('click', '#delete_profile_picture', function(e){
					var id = "<?php echo $id;?>";
					e.preventDefault();
					$.ajax({
						url: "deletions/admin_delete_profile_picture.php",
						method: "POST",
						data: {user_id : id},
						dataType: "html",
						success: function(data){
							$("#delete_profile_picture_message").html(data);
							displayProfilePicture();
						}
					})
				})
				function displayProfilePicture(){
					var id = "<?php echo $id;?>";
					$.ajax({
						url: "displays/admin_display_profile_picture.php",
						method: "POST",
						data: {id : id},
						dataType: "html",
						success: function(data){
							$("#display_profile_picture").html(data);
						}
					})
				}
				$(document).on('submit', '#edit_profile_form', function(e){
					e.preventDefault();
					var id = "<?php echo $id;?>";
					var email = $("#email").val();
					var first_name = $("#first_name").val();
					var last_name = $("#last_name").val();
					var city = $("#city").val();
					var telephone = $('#telephone').val();
					$.ajax({
						url: "handlers/admin_edit_profile_handler.php",
						method: "POST",
						data: {id : id, email : email, first_name : first_name, last_name : last_name, city : city, telephone : telephone},
						dataType: "html",
						beforeSend: function() { 
							$("#edit_profile_button").html("Loading...");
							$("#edit_profile_button").prop("disabled", true);
						},
						success: function(data){
							$("#display_edit_profile_message").html(data);
							$("#edit_profile_button").prop("disabled", false);
							$("#edit_profile_button").html("Save");
							displayEditProfileInformation();
						}
					})
				})
				function displayEditProfileInformation(){
					var id = "<?php echo $id;?>";
					$.ajax({
						url: "displays/admin_display_edit_profile_information.php",
						method: "POST",
						data: {id : id},
						dataType: "json",
						success: function(data){
							$("#username").val(data.username);
							$("#email").val(data.email);
							$("#first_name").val(data.firstname);
							$("#last_name").val(data.lastname);
							$("#city").val(data.city);
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
			<h1>Edit profile:</h1>
			<hr>
			<div id="submit_profile_picture_message"></div>
			<div id="delete_profile_picture_message"></div>
			<div class="row">
				<div class="col-sm-3">
					<div style="text-align: center">
						<div id="display_profile_picture"></div>
					</div>
					<hr>
					<form id="change_profile_picture_form" method="POST" enctype="multipart/form-data">
						<div class="col-sm">
							<label for="profile_picture" class="files_text"><i class="fa fa-upload"></i></label>
							<input type="file" id="profile_picture" name="profile_picture" class="files_element" required><br/>
						<div id="profile_picture_preview"></div>
						</div>
						<hr/>
						<button class="btn btn-primary active btn-block" type="submit">Change picture</button>
					</form>
					<button class="btn btn-danger active btn-block" id="delete_profile_picture">Delete picture</button>
				</div>
				<div class="col-sm-9">
					<h3>Personal information:</h3>  
					<hr>
					<div id="display_edit_profile_message"></div>						
					<form id="edit_profile_form" method="POST">
						<div class="form-group col-sm-8">
							<label for="username">Username:</label>
							<input type="text" name="username" class="form-control" id="username" value="<?php echo $fetch_result['username']; ?>" readonly>
						</div>
						<div class="form-group col-sm-8">
							<label for="email">Email:</label>
							<input type="email" name="email" class="form-control" id="email" value="<?php echo $fetch_result['email']; ?>" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="first_name">First name:</label>
							<input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $fetch_result['first_name']; ?>" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="last_name">Last name:</label>
							<input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo $fetch_result['last_name']; ?>" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="city">City:</label>
							<input type="text" name="city" class="form-control" id="city" value="<?php echo $fetch_result['city']; ?>" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="telephone">Telephone:</label>
							<input type="text" name="telephone" class="form-control" id="telephone" value="<?php echo $fetch_result['telephone']; ?>" required>
						</div> 
						<hr>
						<div class="form-group col-sm-8">  
							<a class="btn btn-secondary" href="profile.php" role="button">Cancel</a>
							<span></span>
							<button class="btn btn-primary" id="edit_profile_button" type="submit">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	function handleProfilePicture(evt) {
		var files = evt.target.files;
		for (var i = 0, f; f = files[i]; i++) {
			if (!f.type.match('image.*')) {
				continue;
			}
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					var span = document.createElement('span');
					span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '"/><i class="fa fa-times-circle delete_profile_picture_icon"></i>'].join('');
					$("#profile_picture_preview").append(span);
				};
			})(f);
			reader.readAsDataURL(f);
		}
	}
	document.getElementById('profile_picture').addEventListener('change', handleProfilePicture, false);

	$(document).on('click', '.delete_profile_picture_icon', function () {
		$("#profile_picture").val("");
		$("#profile_picture_preview").empty();
	})
</script>