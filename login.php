<?php
require_once('connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
	header('location: users/profile.php');
}
if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['username']) && !empty($_POST['username'])){
		$username = mysqli_real_escape_string($link, $_POST['username']);
		if(isset($_POST['password']) && !empty($_POST['password'])){
			$password = mysqli_real_escape_string($link, $_POST['password']);
			$query = "SELECT * FROM users WHERE username = '$username' AND status = 1 AND administrator = 0";
			$result = mysqli_query($link, $query);
			$fetch_result = mysqli_fetch_array($result);
			$counter = mysqli_num_rows($result);
			if($counter == 1){
				if($fetch_result['password'] == $password){
					$_SESSION['username'] = $username;
					header('location: users/profile.php');
				}
				else{
					$unsuccessful_message = "Password is not valid for the entered username!";	
				}
			}
			else{
				$unsuccessful_message = "Username does not exist!";
			}
		}
		else{
			$unsuccessful_message = "Enter your password!";
		}
	}
	else{
		$unsuccessful_message = "Enter your username!";
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
		<link rel="stylesheet" type="text/css" href="style.css?<?php echo date('d-m-Y H:i:s');?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="home.php"><i class="fa fa-home fa-2x"></i></a>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="home.php">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="register.php">Registration</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Forgot</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="users/forgot_username.php">Username</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="users/forgot_password.php">Password</a>
						</div>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="ads/ads.php">Ads</a>
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
			</div>
		</nav>
		<div class="container">
			<?php if(isset($unsuccessful_message)){ ?>
				<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong> <?php echo $unsuccessful_message; ?> </strong> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button></div>
			<?php } ?>
		</div>
		<div class="container">
			<div class="form_box">
				<div class="form_top">
					<div class="form_top_left">
						<h3>Log in</h3>
						<p>Enter your username and password to log in:</p>
					</div>
					<div class="form_top_right">
						<i class="fas fa-key"></i>
					</div>
				</div>
				<div class="form_bottom">
					<form id="login_form" method="POST">
						<div class="form-group">
							<input type="text" name="username" class="form-control username_login" id="username" placeholder="Username..." required>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="password" class="form-control password_login" id="password" placeholder="Password..." required>
								<div class="input-group-append">
									<button class="btn btn-light password_button" type="button"><i class="fa fa-eye"></i></button>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm">
								<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(".password_button").on('click',function() {
		$("i", this).toggleClass("fa-eye-slash");
		var pass = $("#password");
		if (pass.attr('type') === 'password') {
			pass.attr('type', 'text');
		} 
		else {
			pass.attr('type', 'password');
		}
	});
</script>