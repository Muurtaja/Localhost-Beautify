<?php

$Webservice = new Webservice();
$Webservice::$host = "http://localhost";
$Webservice::$physicalPath = "/var/www";
$localhost = $Webservice::$host;

$Webservice::$Online = array(
	array(
		"value"=>"<i class='glyphicon glyphicon-list-alt'></i> CRM - Worklog",
		"link"=>"#"),
	array(
		"value"=>"<i class='glyphicon glyphicon-calendar'></i> Calendar Work",
		"link"=>"#"),
	array(
		"value"=>"<i class='glyphicon glyphicon-envelope'></i> Mail Work",
		"link"=>"#"),
);

$Webservice::$Offline = array(
	array(
		"value"=>"<i class='glyphicon glyphicon-list'></i> phpMyAdmin",
		"link"=>$localhost .'phpmyadmin'),
	array(
		"value"=>"Project 1",
		"link"=>$localhost .'#'),
	array(
		"value"=>"Project 2",
		"link"=>$localhost.'#'),
	array(
		"value"=>"Project 3",
		"link"=>$localhost.'#'),
);
/*
$con=mysqli_connect("example.com","peter","abc123","my_db");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_close($con);
 */

?>