<?php
require_once('../connect.php');
mysqli_set_charset($link,"utf8");

$ads_query = "SELECT * FROM ads";
$ads_result = mysqli_query($link, $ads_query);
$ads_counter = mysqli_num_rows($ads_result);
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
				$(document).on('submit', '#search_page_form',function(e){
					e.preventDefault();
					var inquiry = $("#inquiry").val();
					console.log(inquiry);
					$.ajax({
						url: "handlers/search_handler.php",
						method: "POST",
						data: {inquiry : inquiry},
						dataType: "html",
						success: function(data){
							$("#display_ads").html(data);
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
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<ul class="list-group" style="list-style-type:none">
						<li><a class="btn btn-dark btn-block btn-lg" href="ads.php" role="button">All ads <span class="badge badge-light"><?php echo $ads_counter; ?></span></a></li>
						<li><a class="btn btn-dark btn-block btn-lg" href="my_ads.php" role="button">My ads</a></li>
						<li><a class="btn btn-dark btn-block btn-lg" href="new_ad.php" role="button">New ad</a></li>
						<li><a class="btn btn-dark btn-block btn-lg" href="search_page.php" role="button">Search</a></li>
					</ul>
					<div class="dropright btn-block">
						<?php
							$categories = "SELECT * FROM categories";
							$categories_result = mysqli_query($link, $categories);
							$categories_counter = mysqli_num_rows($categories_result);
						?>
						<button type="button" class="btn btn-dark btn-block btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories <span class="badge badge-light"><?php echo $categories_counter; ?></span></button>
						<div class="dropdown-menu">	
						<?php
							while ($fetch_categories = mysqli_fetch_assoc($categories_result)){
								$title = $fetch_categories['title'];
								$ads_category_query = "SELECT * FROM ads WHERE category = '$title'";
								$ads_category_result = mysqli_query($link, $ads_category_query);
								$ads_category_counter = mysqli_num_rows($ads_category_result);
						?>
							<a class="dropdown-item" href="ads_category.php?id=<?php echo $fetch_categories['id']; ?>"><?php echo $fetch_categories['title']; ?> <span class="badge badge-light"><?php echo $ads_category_counter; ?></span></a>
						<?php
							}
						?>
						</div>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<form id="search_page_form" method="POST">
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
					<div class="container">
						<div id="display_ads"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
