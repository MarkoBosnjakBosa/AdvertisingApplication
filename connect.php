<?php
$link = mysqli_connect('localhost', 'root', '', 'AdvertisingApplication');
if(!$link){
	echo "Connecting to the databse was unsuccessful!";
	echo "<br/>";
	echo mysqli_connect_error($link);
}
$database = mysqli_select_db($link, 'AdvertisingApplication');
if(!$link){
	echo "The selected database was not found!";
	echo "<br/>";
	echo mysqli_connect_error($link);
}
?>