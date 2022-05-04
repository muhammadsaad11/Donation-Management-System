<?php
	
	require 'connection.php';
	
	$fetch_don_prog = "SELECT * FROM programs";
	$result_fetch_don = mysqli_query($db, $fetch_don_prog);
	$response['data'] = array();
	while ($fetch_don_row = mysqli_fetch_assoc($result_fetch_don))
	{
		array_push($response['data'], $fetch_don_row);
	}
	echo json_encode($response);

?>