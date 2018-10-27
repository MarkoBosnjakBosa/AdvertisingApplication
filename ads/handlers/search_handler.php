<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['inquiry']) && !empty($_POST['inquiry'])){
		$inquiry = mysqli_real_escape_string($link, $_POST['inquiry']);
		$query =  "SELECT * FROM ads WHERE (title LIKE '%" . $inquiry . "%') OR (description LIKE '%" . $inquiry . "%')";
		$result = mysqli_query($link, $query);
		$counter = mysqli_num_rows($result);
		$display_message = "";
		if($counter > 0){
			while($fetch_result = mysqli_fetch_array($result)){
				$display_message = "
					<div class='card'>
						<div class='card-header'>
							<div class='row'>
								<div class='col-sm-6'>" . $fetch_result['title'] . "</div>
								<div class='col-sm-6' style='text-align: right'>" . $fetch_result['price'] . " €</div>
							</div>
						</div>
						<div class='card-body'>" . $fetch_result['description'] . "</div>
						<div class='card-footer'>
								<div class='row'>
									<div class='col-sm-6'>
										<a class='btn btn-info' href='view_ad.php?id=" . $fetch_result['id'] . "' role='button'>Detailed</a>
									</div>
									<div class='col-sm-6' style='text-align: right'>" . $fetch_result['publication_time'] . "</div>
								</div>
							</div>
						</div>
					</div>
				";
			}  
		}
		else{
			$display_message = "
				<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><strong>No matching results!</strong> 
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button></div>
			";
		}
	}
	else{
		$display_message = "
			<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'><strong>You have to enter a keyword!</strong> 
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button></div>
		";
	}
	echo $display_message;
}