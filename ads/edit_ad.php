<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = $_GET['id'];
	$ad_query = "SELECT * FROM ads WHERE id = '$id'";
	$ad_result = mysqli_query($link, $ad_query);
	$fetch_ad_result = mysqli_fetch_assoc($ad_result);
	$counter = mysqli_num_rows($ad_result);
	if($counter == 0){
		header('location: my_ads.php');
	}
}
$query = "SELECT * FROM ads WHERE id='$id'";
$result = mysqli_query($link, $query);
$fetch_result = mysqli_fetch_assoc($result);
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
				displayAdAvatar();
				displayCities();
				displayCategories();
				displayEditAdInformation();
				$(document).on('submit', '#change_ad_avatar_form', function(e){
					e.preventDefault();
					var formData = new FormData();
					formData.append("ad_picture", $("#ad_picture")[0].files[0]);
					formData.append("id", "<?php echo $id;?>");
					$.ajax({
						url: "submissions/submit_ad_avatar.php",
						method: "POST",
						data: formData,  
						contentType: false, 
						processData: false,
						success: function(data){
							$("#submit_ad_avatar_message").html(data);
							displayAdAvatar();
							$("#ad_picture").val("");
							$("#ad_picture_preview").empty();
						}
					})
				})
				$(document).on('click', '#delete_ad_avatar_button', function(e){
					var id = "<?php echo $id;?>";
					e.preventDefault();
					$.ajax({
						url: "deletions/delete_ad_avatar.php",
						method: "POST",
						data: {id : id},
						dataType: "html",
						success: function(data){
							$("#delete_ad_avatar_message").html(data);
							displayAdAvatar();
						}
					})
				})
				function displayAdAvatar(){
					var id = "<?php echo $id;?>";
					$.ajax({
						url: "displays/display_ad_avatar.php",
						method: "POST",
						data: {id : id},
						dataType: "html",
						success: function(data){
							$('#display_ad_avatar').html(data);
						}
					})
				}
				$(document).on('submit', '#edit_ad_form', function(e){
					e.preventDefault();
					var id = "<?php echo $id;?>";
					var title = $("#title").val();
					var description = $("#description").val();
					var price = $("#price").val();
					var city = $("#city").val();
					var condition = $("input[name=condition]:checked").val();
					var category = $("#category").val();
					$.ajax({
						url: "handlers/edit_ad_handler.php",
						method: "POST",
						data: {id : id, title : title, description : description, price : price, city : city, condition : condition, category : category},
						dataType: "html",
						success: function(data){
							$("#display_edit_ad_message").html(data);
							displayEditAdInformation();
						}
					})
				})
				function displayCities(){
					$.ajax({
						url: "displays/display_cities.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							$.each(data.cities, function(){
								$("#city").append($("<option>", {value: this.title, text: this.title}));
							});
						}
					})
				}
				function displayCategories(){
					$.ajax({
						url: "displays/display_categories.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							$.each(data.categories, function(){
								$("#category").append($("<option>", {value: this.title, text: this.title}));
							});
						}
					})
				}
				function displayEditAdInformation(){
					var id = "<?php echo $id;?>";
					$.ajax({
						url: "displays/display_edit_ad_information.php",
						method: "POST",
						data: {id : id},
						dataType: "json",
						success: function(data){
							$("#title").val(data.title);
							$("#description").val(data.description);
							$("#price").val(data.price);
							$("#city").val(data.city);
							var string = data.condition;
							var condition = string.toLowerCase();
							$("#" + condition).prop("checked", true);
							$("#category").val(data.category);
						}
					})
				}
				tinymce.init({
					selector: "#description",
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
						<a class="nav-link" href="ads.php">Ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="my_ads.php">My ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="new_ad.php">New ad</a>
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
							<a class="dropdown-item" href="../users/profile.php">Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="../users/change_password.php">Change password</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="../logout.php">Log out</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container"> 
			<div class="jumbotron">
				<div style="text-align: center">
					<h1>Edit the ad:</h1>
				</div>
				<hr>
				<div id="submit_ad_avatar_message"></div>
				<div id="delete_ad_avatar_message"></div>
				<div class="row">
					<div class="col-sm-3">
						<div id="display_ad_avatar"></div>
					</div>
					<div class="col-sm-3">
						<form id="change_ad_avatar_form" method="POST" enctype="multipart/form-data">
							<div class="col-sm">
								<label for="ad_picture" class="files_text"><i class="fa fa-upload"></i></label>
								<input type="file" id="ad_picture" name="ad_picture" class="files_element" required><br/>
								<div id="ad_picture_preview"></div>
							</div>
							<hr/>
							<button class="btn btn-primary active btn-block" type="submit">Change picture</button>
						</form>
						<button class="btn btn-danger active btn-block" id="delete_ad_avatar_button">Delete picture</button>
					</div>
				</div>
				<hr>
				<div id="display_edit_ad_message"></div>
				<form id="edit_ad_form" method="POST">
					<div class="form-group row">
						<label for="title" class="col-sm-2 col-form-label">Title:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title" id="title" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="description" class="col-sm-2 col-form-label">Description:</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description" id="description" rows="5"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="price" class="col-sm-2 col-form-label">Price:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="price" id="price" required>
							<small id="price_text" class="form-text text-muted">
								Specify the price in Euros (€)!
							</small>
						</div>
					</div>
					<div class="form-group row">
						<label for="city" class="col-sm-2 col-form-label">City:</label>
						<div class="col-sm-4">
							<select class="custom-select my-1 mr-sm-2" name="city" id="city" required></select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Condition:</label>
						<div class="col-sm-10">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="condition" id="new" value="New" required>
								<label class="form-check-label" for="new">New</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="condition" id="used" value="Used">
								<label class="form-check-label" for="used">Used</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="condition" id="damaged" value="Damaged">
								<label class="form-check-label" for="damaged">Damaged</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="category" class="col-sm-2 col-form-label">Category:</label>
						<div class="col-sm-4">
							<select class="custom-select my-1 mr-sm-2" name="category" id="category" required></select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-sm">
							<a class="btn btn-secondary btn-lg btn-block" href="my_ads.php" role="button">Cancel</a>
						</div>
						<div class="col-sm">
							<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
						</div>
					</div>
				</form>
           </div>
		</div>
	</body>
</html>
<script type="text/javascript">
	function handleAdPicture(evt) {
		var files = evt.target.files;
		for (var i = 0, f; f = files[i]; i++) {
			if (!f.type.match('image.*')) {
				continue;
			}
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					var span = document.createElement('span');
					span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '"/><i class="fa fa-times-circle delete_ad_picture_icon"></i>'].join('');
					$("#ad_picture_preview").append(span);
				};
			})(f);
			reader.readAsDataURL(f);
		}
	}
	document.getElementById('ad_picture').addEventListener('change', handleAdPicture, false);
	
	$(document).on('click', '.delete_ad_picture_icon', function () {
		$("#ad_picture").val("");
		$("#ad_picture_preview").empty();
	})
</script>