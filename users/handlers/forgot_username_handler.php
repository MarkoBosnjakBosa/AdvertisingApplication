<?php
require_once('../../connect.php');
mysqli_set_charset($link,"utf8");
 
if(isset($_POST) && !empty($_POST)){
	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = mysqli_real_escape_string($link, $_POST['email']);
		$query = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($link, $query);
		$counter = mysqli_num_rows($result);
		if($counter == 1){
			$alert_type = "success";
			$alert_message = "An email containing your username has been sent to your email address!";
			$fetch_result= mysqli_fetch_assoc($result);
			$first_name = $fetch_result['first_name'];
			$username = $fetch_result['username'];
			$to = $email;
			$subject = 'Small Ads - Username';
			$message = '<html>
							<body>
								<p><h2>Dear ' . $first_name . ',</h2></p> 
								<p><h3>your username is: ' . $username . '</h3></p>
								<p><h3>Kind regards,<br/>
								Small Ads</h3></p>
							</body>
						</html>';
			$headers[] = 'From: Small Ads <small.ads@gmail.com>';
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';

			mail($to, $subject, $message, implode("\r\n", $headers));
		} 
		else{
			$alert_type = "danger";
			$alert_message = "The email address doesn't exist!";
		}
	}
	else{
		$alert_type = "danger";
		$alert_message = "Enter your email address!";
	}
	$display_message = "
		<div class='alert alert-" . $alert_type . " alert-dismissible fade show text-center' role='alert'><strong>" . $alert_message . "</strong> 
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button></div>
	";
	echo $display_message;
}
?>