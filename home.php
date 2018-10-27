<?php
require_once('connect.php');
mysqli_set_charset($link,"utf8");
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
					<li class="nav-item active">
						<a class="nav-link" href="login.php">Log in</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="ads/ads.php">Ads</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="privacy_policy.php">Privacy policy</a>
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
						<a class="nav-link" href="administration/admin_login.php">Administration</a>
					</li>
				</ul>
			</div>
		</nav>
		<nav>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form action="ads/search.php" method="GET">
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
		<div id="carousel" class="carousel slide" data-ride="carousel">
			<ul class="carousel-indicators">
			<?php 
				$data_query = "SELECT * FROM home_page_pictures";
				$data_result = mysqli_query($link, $data_query);
				$counter = mysqli_num_rows($data_result);
				if($counter > 0){
					$data_counter = 0;
					while ($data_fetch_result = mysqli_fetch_assoc($data_result)){
						if($data_counter == 0){
							echo "<li data-target='#carousel' data-slide-to='0' class='active'></li>";
						}
						else{
							echo "<li data-target='#carousel' data-slide-to='" . $data_counter . "'></li>";
						}
						$data_counter++;
					}
				}
				else{
					echo "<li data-target='#carousel' data-slide-to='0' class='active'></li>";
				}
			?>
			</ul>
			<div class="carousel-inner">
				<?php 
					$picture_query = "SELECT * FROM home_page_pictures";
					$picture_result = mysqli_query($link, $picture_query);
					$pic_counter = mysqli_num_rows($picture_result);
					if($pic_counter > 0){
						$picture_counter = 0;
						while ($picture_fetch_result = mysqli_fetch_assoc($picture_result)){
							if($picture_counter == 0){
								echo "<div class='carousel-item active'>
										<img src='administration/" . $picture_fetch_result['title'] . "' alt='picture" . $picture_counter . "' style='width: 100%; height: 500px'>
										<div class='carousel-caption'>
											<h3>" . $picture_fetch_result['caption'] . "</h3>
										</div>
									</div>";
							}
							else{
								echo "<div class='carousel-item'>
										<img src='administration/" . $picture_fetch_result['title'] . "' alt='picture" . $picture_counter . "' style='width: 100%; height: 500px'>
										<div class='carousel-caption'>
											<h3>" . $picture_fetch_result['caption'] . "</h3>
										</div>
									</div>";
							}
							$picture_counter++;
						}
					}
					else{
						echo "<div class='carousel-item active'>
								<img src='default_pictures/Welcome.jpg' alt='Welcome picture' style='width: 100%; height: 500px'>
								<div class='carousel-caption'>
									<h3>Welcome</h3>
								</div>
							</div>";
					}
				?>
			</div>
			<a class="carousel-control-prev" href="#carousel" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#carousel" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
		<div class="container-fluid">
			<p>
				<?php 
					$query = "SELECT * FROM home_page_description";
					$result = mysqli_query($link, $query);
					$fetch_result = mysqli_fetch_assoc($result);
					if($fetch_result['description'] == ""){
						echo "<div class='home_page_text'>
								<h1>Small Ads</h1><br/>
								<h3>Selling, renting or buying?<br/>
								Then you are in the right place!<br/>
								Register and join in a new adventure!!!</h3>
						</div>";
					}
					else{
						echo nl2br($fetch_result['description']);
					}
				?>
			</p>
		</div>
		<div class="info">
			<div class="container">
				<div class="row">
					<div class="col-sm text-center">
						<?php
							$social_networks_query = "SELECT * FROM home_page_social_networks";
							$social_networks_result = mysqli_query($link, $social_networks_query);
							$social_networks_fetch_result = mysqli_fetch_assoc($social_networks_result);
						?>
						<a href="<?php if($social_networks_fetch_result['facebook_url'] == ""){ echo "https://www.facebook.com/"; } else { echo $social_networks_fetch_result['facebook_url']; } ?>" target="_blank" class="fab fa-facebook"></a>
						<a href="<?php if($social_networks_fetch_result['twitter_url'] == ""){ echo "https://twitter.com/"; } else { echo $social_networks_fetch_result['twitter_url']; } ?>" target="_blank" class="fab fa-twitter"></a>
						<a href="<?php if($social_networks_fetch_result['instagram_url'] == ""){ echo "https://instagram.com/"; } else { echo $social_networks_fetch_result['instagram_url']; } ?>" target="_blank" class="fab fa-instagram"></a>
						<a href="<?php if($social_networks_fetch_result['linkedin_url'] == ""){ echo "https://linkedin.com/"; } else { echo $social_networks_fetch_result['linkedin_url']; } ?>" target="_blank" class="fab fa-linkedin"></a>
						<a href="<?php if($social_networks_fetch_result['youtube_url'] == ""){ echo "https://youtube.com/"; } else { echo $social_networks_fetch_result['youtube_url']; } ?>" target="_blank" class="fab fa-youtube"></a>
					</div>
					<div class="col-sm text-center">
						<p>	
						<?php
							$information_query = "SELECT * FROM home_page_information";
							$information_result = mysqli_query($link, $information_query);
							$information_fetch_result = mysqli_fetch_assoc($information_result);
							if($information_fetch_result['name'] == ""){ echo "Name empty"; } else { echo $information_fetch_result['name']; } ?><br/>
							<?php if($information_fetch_result['address'] == ""){ echo "Address empty"; } else { echo $information_fetch_result['address']; } ?><br/>
							<?php if($information_fetch_result['city'] == ""){ echo "City empty"; } else { echo $information_fetch_result['city']; } ?><br/>
							<?php if($information_fetch_result['country'] == ""){ echo "Country empty"; } else { echo $information_fetch_result['country']; } ?>
						</p>
					</div>
					<div class="col-sm text-center">
						<i class="fa fa-envelope fa-fw"></i><?php if($information_fetch_result['email'] == ""){ echo "Email empty"; } else { echo $information_fetch_result['email']; } ?><br/>
						<i class="fa fa-fax fa-fw"></i><?php if($information_fetch_result['fax'] == ""){ echo "Fax empty"; } else { echo $information_fetch_result['fax']; } ?><br/>
						<i class="fa fa-phone fa-fw"></i><?php if($information_fetch_result['telephone'] == ""){ echo "Telephone empty"; } else { echo $information_fetch_result['telephone']; } ?>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<p class="footer">Copyright © 2018 | Marko Bošnjak | All rights reserved</p>
		</footer>
	</body>
</html>