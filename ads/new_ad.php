<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

$user_query = "SELECT * FROM users WHERE username = '$username'";
$user_result = mysqli_query($link, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script>
			$(document).ready(function(){
				displayCities();
				displayCategories();
				$(document).on('submit', '#new_ad_form', function(e){
					e.preventDefault();
					var formData = new FormData();
					formData.append("ad_picture", $("#ad_picture")[0].files[0]);
					var lenght = document.getElementById("pictures").files.length;
					for (var x = 0; x < lenght; x++) {
						formData.append("pictures[]", document.getElementById("pictures").files[x]);
					}
					formData.append("recaptcha", grecaptcha.getResponse());
					formData.append("title", $("#title").val());
					formData.append("description", $("#description").val());
					formData.append("price", $("#price").val());
					formData.append("city", $("#city").val());
					formData.append("condition", $("input[name=condition]:checked").val());
					formData.append("category", $("#category").val());
					formData.append("user_id", "<?php echo $user_id;?>");
					$.ajax({
						url: "handlers/new_ad_handler.php",
						method: "POST",
						data: formData,
						dataType: "html",
						processData: false,
						contentType: false,
						beforeSend: function(){ 
							$("#new_ad_button").html("Saving...");
							$("#new_ad_button").prop("disabled", true);
						},
						success: function(data){
							$("#new_ad_message").html(data);
							$("#new_ad_form").trigger("reset");
							$("#ad_picture_preview").empty();
							$("#pictures_preview").empty();
							$("#delete_pictures_button").remove();
							$("#new_ad_button").prop("disabled", false);
							$("#new_ad_button").html("Submit");
							$(window).scrollTop(0);
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
			<div id="new_ad_message"></div>
			<div class="jumbotron" id="new_ad_jumbotron">
				<div style="text-align: center">
					<h1>Place your ad:</h1>
				</div>
				<hr>
				<form id="new_ad_form" method="POST" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="title" class="col-sm-2 col-form-label">Title:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title" id="title" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="description" class="col-sm-2 col-form-label">Description:</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description" id="description" rows="5" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="price" class="col-sm-2 col-form-label">Price:</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="price" id="price" required>
							<small id="price_text" class="form-text text-muted">
								Specify the price in Euros (€)!
							</small>
						</div>
					</div>
					<div class="form-group row">
						<label for="city" class="col-sm-2 col-form-label">City:</label>
						<div class="col-sm-4">
							<select class="custom-select my-1 mr-sm-2" name="city" id="city" required>
								<option value=""></option>
							</select>
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
							<select class="custom-select my-1 mr-sm-2" name="category" id="category" required>
								<option value=""></option>
							</select>							
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="Here you should specify the avatar of your ad. Only jpg, jpeg and png files are allowed."><span style="border-bottom: 1px dotted">Ad avatar:</span></label>
						<div class="col-sm-10">
							<label for="ad_picture" class="files_text"><i class="fa fa-upload"></i></label>
							<input type="file" id="ad_picture" name="ad_picture" class="files_element" required><br/>
							<div id="ad_picture_preview"></div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="Here you should select all other pictures of your ad. Only jpg, jpeg and png files are allowed."><span style="border-bottom: 1px dotted">Pictures:</span></label>
						<div class="col-sm-10">
							<label for="files" class="files_text"><i class="fa fa-upload"></i></label>
							<input type="file" id="pictures" name="pictures[]" class="files_element" multiple required><br/>
							<div id="pictures_preview"></div>
						</div>
					</div>
					<div class="recaptcha">
						<div class="g-recaptcha" data-sitekey="6Let8k8UAAAAAFM_ifPQxYY4hGMLx4D5sKCTWUTP"></div>
					</div>
					<div class="form-row">
						<div class="col-sm">
							<button class="btn btn-lg btn-danger btn-block" type="reset">Reset</button>
						</div>
						<div class="col-sm">
							<button class="btn btn-lg btn-primary btn-block" id="new_ad_button" type="submit">Submit</button>
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
	
	function handlePictures(evt) {
		var files = evt.target.files;
		for (var i = 0, f; f = files[i]; i++) {
			if (!f.type.match('image.*')) {
				continue;
			}
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					var span = document.createElement('span');
					span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '" style="margin-right: 5px; margin-bottom: 5px;"/></div>'].join('');
					$("#pictures_preview").append(span);
				};
			})(f);
			reader.readAsDataURL(f);
		}
		if($("#delete_pictures_button").length < 1){
			$("#pictures_preview").before("<div style='margin-top: 5px'><button type='button' class='btn btn-danger delete_pictures_button' id='delete_pictures_button'>Delete all pictures</button></div>");
		}
	}
	document.getElementById('pictures').addEventListener('change', handlePictures, false);
	
	$(document).on('click', '.delete_pictures_button', function () {
		$("#pictures").val("");
		$("#pictures_preview").empty();
		$("#delete_pictures_button").remove();
	})
</script>