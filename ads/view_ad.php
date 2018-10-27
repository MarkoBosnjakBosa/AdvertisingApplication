<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");

if(isset($_GET['id']) && !empty($_GET['id'])){
	$ad_id = $_GET['id'];
	$query = "SELECT * FROM ads WHERE id = '$ad_id'";
	$result = mysqli_query($link, $query);
	$fetch_result = mysqli_fetch_assoc($result);
	$counter = mysqli_num_rows($result);
	if($counter == 0){
		header('location: ads.php');
	}
}

$user_id = $fetch_result['user_id'];
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($link, $user_query);
$user = mysqli_fetch_assoc($user_result);
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
					<li class="nav-item active">
						<a class="nav-link" href="../users/profile.php">Profile</a>
					</li>
				</ul>
			</div>
		</nav>
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
					<a class="nav-link active" href="view_ad.php?id=<?php echo $fetch_result['id']; ?>">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ad_pictures.php?ad_id=<?php echo $fetch_result['id']; ?>">Pictures</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="comments.php?ad_id=<?php echo $fetch_result['id']; ?>">Comments</a>
				</li>
			</ul>
		</div>
		<div class="jumbotron">	
			<div class="container">
				<div class="row">				
					<div class="col-sm-2 text-center" id="user_profile" style="height: 225px">
						<?php
							if(isset($user['profile_picture']) && !empty($user['profile_picture'])){
								$url = "../users/".$user['profile_picture'];
							}
							else {
								$url = "../default_pictures/avatar_picture.jpg";
							}
						?>
						<img src="<?php echo $url; ?>" alt="Avatar" class="rounded-circle" style="height: 100px; width: 100px; border: 1px solid">
						<p style="margin-top: 10px;"><b><?php echo $user['username']; ?></b></p>
						<a href="../users/view_profile.php?id=<?php echo $user_id ?>" class="btn btn-info" role="button">Profile</a>
					</div>				
					<div class="col-sm-10">
						<div style="text-align: center">
							<h1><?php echo $fetch_result['title']; ?></h1>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4">	
								<h3>Information:</h3>
							</div>
							<div class="col-sm-4">
								<p>Category: <b><?php echo $fetch_result['category']; ?></b></p>
								<p>Condition: <b><?php echo $fetch_result['condition']; ?></b></p>
								<p>City: <b><?php echo $fetch_result['city']; ?></b></p>
								<p>Price: <b><?php echo $fetch_result['price']; ?> €</b></p>
								<p><b><?php echo $fetch_result['publication_time']; ?></b></p>
							</div>
							<div class="col-sm-4">
								<img src="<?php if(isset($fetch_result['ad_picture']) && !empty($fetch_result['ad_picture'])){ echo $fetch_result['ad_picture']; }else{ echo "../default_pictures/ad_picture.png";} ?>" alt ="Ad picture" class="img-fluid rounded" style="height: 180px; width: 180px; border: 1px solid">							
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4">	
								<h3>Description:</h3>
							</div>
							<div class="col-sm-8">
								<p><?php echo $fetch_result['description']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>