<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");
session_start();
if(isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])){
	header('location: ads_list.php');
}
if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['username']) && !empty($_POST['username'])){	
		$username = mysqli_real_escape_string($link, $_POST['username']);
		if(isset($_POST['password']) && !empty($_POST['password'])){
			$password = mysqli_real_escape_string($link, $_POST['password']);
			$query = "SELECT * FROM users WHERE username = '$username' AND administrator = 1";
			$result = mysqli_query($link, $query);
			$fetch_result = mysqli_fetch_array($result);
			$counter = mysqli_num_rows($result);
			if($counter == 1){
				if($fetch_result['password'] == $password){
					$_SESSION['admin_username'] = $username;
					header('location: admin_profile.php');
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
		<link rel="stylesheet" type="text/css" href="../style.css?<?php echo date('d-m-Y H:i:s');?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	</head>
	<body>	
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
						<h3>Administrator area</h3>
						<p>Enter your username and password to log in:</p>
					</div>
					<div class="form_top_right">
						<i class="fas fa-key"></i>
					</div>
				</div>
				<div class="form_bottom">
					<form id="admin_login_form" method="POST">
						<div class="form-group">
							<input type="text" name="username" class="form-control admin_username_login" id="username" placeholder="Username..." required>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="password" class="form-control admin_password_login" id="password" placeholder="Password..." required>
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
		var password = $("#password");
		if (password.attr('type') === 'password') {
			password.attr('type', 'text');
		} 
		else {
			password.attr('type', 'password');
		}
	});
</script>