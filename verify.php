<?php
require_once('connect.php');
mysqli_set_charset($link,"utf8");

if(isset($_GET['verification_key']) && !empty($_GET['verification_key'])){
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$verification_key = $_GET['verification_key'];
		$query = "SELECT * FROM users WHERE verification_key = '$verification_key' AND status = 0 AND administrator = 0";
		$result = mysqli_query($link, $query);
		$counter = mysqli_num_rows($result);
		$fetch_result = mysqli_fetch_assoc($result);
		$id = $fetch_result['id'];
		if($counter == 1){
			$unsuccessful_message = "Your account has already been activated!";
		}
		else{
			$update_query = "UPDATE users SET status = 1 WHERE id = $id";
			$update_result = mysqli_query($link, $update_query);
			if($update_result){
				$successful_message = "Your account has been activated!";
			}
		}
	}
	else{
		$unsuccessful_message = "The user ID is missing!";
	}
}
else{
    $unsuccessful_message = "The user verification key is missing!";
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
		<div class="container">
			<?php if(isset($successful_message)){ ?>
				<div class="alert alert-success alert-dismissible fade show text-center" role="alert"><strong> <?php echo $successful_message; ?> </strong> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button></div>
			<?php } ?>
			<?php if(isset($unsuccessful_message)){ ?>
				<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><strong> <?php echo $unsuccessful_message; ?> </strong> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button></div>
			<?php } ?>
		</div>
	</body>
</html>