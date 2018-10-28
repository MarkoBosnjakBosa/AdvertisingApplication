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
		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>		
		<script type="text/javascript">
			$(document).ready(function(){
				displayPrivacyPolicy();
				function displayPrivacyPolicy(){
					$.ajax({
						url: "displays/display_privacy_policy.php",
						method: "GET",
						dataType: "json",
						success: function(data){
							var privacy_policy = data.privacy_policy;
							if(privacy_policy == "0"){
								$("#privacy_policy_dialog").modal("show");
							}
							else{
								$("#privacy_policy_dialog").modal("hide");
							}
						}
					})
				}
				$(document).on('click', '#confirm_privacy_policy_button', function(){
					var id = "<?php echo $id; ?>";
					$.ajax({
						url: "handlers/privacy_policy_handler.php",
						method: "POST",
						data: {id : id},
						dataType: "html",
						success: function(data){
							$("#privacy_policy_dialog").modal("hide");
							$("#privacy_policy_message").html(data);
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
		<div id="privacy_policy_message"></div>
		<div class="modal fade" id="privacy_policy_dialog" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="privacyPolicyDialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Privacy policy notification</h5>
					</div>
					<div class="modal-body">
						<?php 
							$privacy_policy_query = "SELECT * FROM privacy_policy";
							$privacy_policy_result = mysqli_query($link, $privacy_policy_query);
							$privacy_policy_fetch_result = mysqli_fetch_assoc($privacy_policy_result);
							$privacy_policy_link = $privacy_policy_fetch_result['privacy_policy'];
							if($privacy_policy_link == ""){
								echo "You have to review and accept the privacy policy before continuing.<br/>
										If you don't accept the privacy policy, you'll be immediately logged out.";
							}
							else{
								echo "You have to review and accept the <a href='../privacy_policy.php' target='_blank'>privacy policy</a> before continuing.<br/>
										If you don't accept the <a href='../privacy_policy.php' target='_blank'>privacy policy</a>, you'll be immediately logged out.";
							}
						?>
					</div>
					<div class="modal-footer">
						<a class="btn btn-secondary" href="../logout.php" role="button">Cancel</a>
						<button type="button" id="confirm_privacy_policy_button" class="btn btn-primary">Confirm</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container">    
			<div class="jumbotron">
				<div class="row">
					<div class="col-sm-4">
						<img src="<?php if(isset($fetch_result['profile_picture']) && !empty($fetch_result['profile_picture'])){ echo $fetch_result['profile_picture']; }else{ echo "../default_pictures/avatar_picture.jpg";} ?>" alt ="Profile šicture" id="profile_picture" class="img-fluid rounded" style="height: 256px; width:256px; border: 1px solid;"> 
					</div>
					<div class="col-sm-8">
						<h2><?php echo $fetch_result['first_name'] . " " . $fetch_result['last_name']; ?></h2>
						<hr>
						<div class="col-sm">
							<p><i class="fa fa-user fa-fw"></i><?php echo $fetch_result['username']; ?></p>
							<p><i class="fa fa-envelope fa-fw"></i><?php echo $fetch_result['email']; ?></p>
							<p><i class="fa fa-phone fa-fw"></i><?php echo $fetch_result['telephone']; ?></p>
							<p><i class="fa fa-map-marker fa-fw"></i><?php echo $fetch_result['city']; ?></p>
						</div>
						<div class="col-sm">           
							<a class="btn btn-primary" href="edit_profile.php" role="button">Edit</a>
							<span></span>
							<button type="button" class="btn btn-success active">Active</button>
						</div>
					</div>
				</div>
           </div>
		</div>
	</body>
</html>