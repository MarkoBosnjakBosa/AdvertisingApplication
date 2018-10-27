<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
	header('location: ../login.php');
}
$username = $_SESSION['username'];

if(isset($_GET['ad_id']) && !empty($_GET['ad_id'])){
	$ad_id = $_GET['ad_id'];
	$query = "SELECT * FROM ads WHERE id='$ad_id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$counter = mysqli_num_rows($result);
	if($counter == 0){
		header('location: ads.php');
	}
}
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
		<script>
			$(document).ready(function(){
				displayComments();
				$(document).on('submit', '#comments_form', function(e){
					e.preventDefault();
					var content = $("#content").val();
					var username = "<?php echo $username; ?>";
					var ad_id = "<?php echo $ad_id; ?>";
					var mother_id = $("#mother_id").val();
					$.ajax({
						url: "submissions/submit_comment.php",
						method: "POST",
						data: {content : content, username : username, ad_id : ad_id, mother_id : mother_id},
						dataType: "html",
						beforeSend: function(){ 
							$("#submit_comment_button").html("Saving...");
							$("#submit_comment_button").prop("disabled", true);
						},
						success: function(data){
							$("#submit_comment_message").html(data);
							$("#comments_form")[0].reset();
							$("#mother_id").val('0');
							$("#submit_comment_button").prop("disabled", false);
							$("#submit_comment_button").html("Submit");
							displayComments();
						}
					})
				})
				function displayComments(){
					var ad_id = "<?php echo $ad_id; ?>";
					$.ajax({
						url: "displays/display_comments.php",
						method: "POST",
						data: {ad_id : ad_id},
						dataType: "html",
						success: function(data){
							$("#display_comments").html(data);
						}
					})
				}
				$(document).on('click', '.reply', function(){
					var mother_id = $(this).attr("id");
					$("#mother_id").val(mother_id);
					$("#content").focus();
				}); 
			});
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
		<nav>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form action="search.php" method="GET">
							<div class="input-group">
								<input type="text" name="inquiry" id="inquiry" placeholder="Search..." class="form-control" required>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-secondary" id="search_button"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</nav>
		<div class="container">
			<ul class="nav nav-tabs justify-content-center">
				<li class="nav-item">
					<a class="nav-link" href="view_my_ad.php?id=<?php echo $fetch_result['id']; ?>">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="my_ad_pictures.php?ad_id=<?php echo $fetch_result['id']; ?>">Pictures</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="my_questions.php?ad_id=<?php echo $fetch_result['id']; ?>">Comments</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div style="text-align: center; margin-top: 10px">
				<h1><?php echo $fetch_result['title']; ?></h1>
			</div>
			<hr>
			<div id="submit_comment_message"></div>
			<form id="comments_form" method="POST">
				<div class="form-group">
					<textarea name="content" id="content" class="form-control" rows="5" required></textarea>
				</div>
    			<div class="form-group">
					<input type="hidden" name="mother_id" id="mother_id" value="0"/>
					<div style="text-align: right">
						<input type="submit" id="submit_comment_button" class="btn btn-success" value="Submit"/>
					</div>
				</div>
			</form>
			<div id="display_comments"></div>
		</div>
	</body>
</html>