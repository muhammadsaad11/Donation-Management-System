<?php
session_start();
require 'connection.php';

if (isset($_GET['token']))
{
	$token = $_GET['token'];
	
	$update_query = "UPDATE user set verify=1 where vtoken='$token'";

	$results = mysqli_query($db, $update_query);

	if($results)
	{
		header('location:dashboard2.php');
	}
}
?>