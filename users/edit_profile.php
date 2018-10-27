<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = '$username'";
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
				$(document).on('submit', '#change_profile_picture_form',function(e){
					e.preventDefault();
					var formData = new FormData($(this)[0]);
					formData.append("user_id", "<?php echo $id;?>");
					$.ajax({
						url: "submit_profile_picture.php",
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
				$(document).on('click', '#delete_profile_picture',function(e){
					var id = "<?php echo $id;?>";
					e.preventDefault();
					$.ajax({
						url: "delete_profile_picture.php",
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
						url: "displays/display_profile_picture.php",
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
						url: "handlers/edit_profile_handler.php",
						method: "POST",
						data: {id : id, email : email, first_name : first_name, last_name : last_name, city : city, telephone : telephone},
						dataType: "html",
						beforeSend: function() { 
							$("#edit_profile_button").html('Loading...');
							$("#edit_profile_button").prop('disabled', true);
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
					console.log(id);
					$.ajax({
						url: "displays/display_edit_profile_information.php",
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
						<a class="nav-link" href="../ads/ads.php">Ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="../ads/my_ads.php">My ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="../ads/new_ad.php">New ad</a>
					</li>
					<li class="nav-item active">
						<button type="button" class="btn btn-light" data-toggle="modal" data-target="#send_message_modal">Contact</button>
						<div class="modal fade" id="send_message_modal" tabindex="-1" role="dialog" aria-labelledby="label_modal" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="label_modal">Send a message:</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form action="mailto:small.ads@gmail.com" method="POST" enctype="text/plain">
											<div class="form-group row">
												<label for="contact_first_name" class="col-sm-4 col-form-label">First name:</label>
												<div class="col-sm-8">
													<input type="text" name="contact_first_name" class="form-control" id="contact_first_name" style="margin-bottom: 0px;">
												</div>
											</div>
											<div class="form-group row">
												<label for="contact_last_name" class="col-sm-4 col-form-label">Last name:</label>
												<div class="col-sm-8">
													<input type="text" name="contact_last_name" class="form-control" id="contact_last_name" style="margin-bottom: 0px;">
												</div>
											</div>
											<div class="form-group row">
												<label for="contact_email" class="col-sm-4 col-form-label">Email:</label>
												<div class="col-sm-8">
													<input type="email" name="contact_email" class="form-control" id="contact_email" style="margin-bottom: 0px;">
												</div>
											</div>
											<div class="form-group row">
												<label for="message" class="col-sm-4 col-form-label">Message:</label>
												<div class="col-sm-8">
													<textarea name="message" class="form-control" id="message" style="margin-bottom: 0px;"></textarea>
												</div>
											</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<input type="submit" class="btn btn-primary" value="Send">
									</div>
										</form>
								</div>
							</div>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $username; ?><span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="profile.php">Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="change_password.php">Change password</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="../logout.php">Log out</a>
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
							<input type="text" name="username" class="form-control" id="username" readonly>
						</div>
						<div class="form-group col-sm-8">
							<label for="email">Email:</label>
							<input type="email" name="email" class="form-control" id="email" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="first_name">First name:</label>
							<input type="text" name="first_name" class="form-control" id="first_name" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="last_name">Last name:</label>
							<input type="text" name="last_name" class="form-control" id="last_name" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="city">City:</label>
							<input type="text" name="city" class="form-control" id="city" required>
						</div>
						<div class="form-group col-sm-8">
							<label for="telephone">Telephone:</label>
							<input type="text" name="telephone" class="form-control" id="telephone" required>
						</div> 
						<hr>
						<div class="form-group col-sm-8">  
							<a class="btn btn-secondary" href="profile.php" role="button">Cancel</a>
							<span></span>
							<button class="btn btn-primary" id="edit_profile_button "type="submit">Save</button>
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