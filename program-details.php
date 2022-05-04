<?php

session_start();
require 'connection.php';
$email = $_SESSION['email'];
$query = "SELECT * FROM user WHERE email = '$email'";
$results = mysqli_query($db, $query);
$user_data_row = mysqli_fetch_assoc($results);


if(!isset($_SESSION['email']))
{
	$_SESSION['msg'] = "You must log in first to view this page";
	header("location: index.php");
}


if (isset($_GET['prog_id']))
{
	$program_id = (int)$_GET['prog_id'];
	$_SESSION['prog_id'] = $program_id;
	$fetch_program_det = "SELECT program_name, org_name, prog_details FROM programs WHERE id = '$program_id'";
	$result_fetch_pdet = mysqli_query($db, $fetch_program_det);
	$fetch_pdet_row = mysqli_fetch_assoc($result_fetch_pdet);
	$prog_name_don = $fetch_pdet_row['program_name'];
	$org_name_don = $fetch_pdet_row['org_name'];
}

$user_id = $user_data_row['id'];

$program_id = $_SESSION['prog_id'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php echo($prog_name_don); ?></title>
	<link rel="shortcut icon" href="img/EF8.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard-style.css">
	<link rel="stylesheet" type="text/css" href="css/program-details.css">
</head>
<body>
	<input type="checkbox" id="nav-toggle">
	<div class="sidebar">
		<div class="sidebar-brand">
			<h2><span><img src="img/EF9.png"></span><span>EasyFunds</span></h2>
		</div>

		<div class="sidebar-menu">
			<ul>
				<li><a href="dashboard.php"><span class="las la-igloo"></span><span>Dashboard</span></a>
				</li>

				<li><a href="donation_programs.php"><span class="las la-hand-holding-heart"></span><span>Donation Programs</span></a>
				</li>

				<li><a href="edit-profile.php"><span class="las la-user-circle"></span><span>Account</span></a>
				</li>
			</ul>
			<button onclick="location.href='logout.php'" type="button" class="logout-btn"><span class="las la-sign-out-alt"></span><span>Logout</span></button>
		</div>
	</div>

	<div class="main-content">
		<header class="header-title">
			<h2>
				<label for="nav-toggle">
					<span class="las la-bars"></span>
				</label>
				Program Details
			</h2>

			<div class="user-wrapper">
				<img src="img/picture-not-present.jpg" width="40px" height="40px" alt="">
				<div>
					<h4><?php echo $_SESSION['fname']; ?></h4>
					<small>User</small>
				</div>
			</div>
		</header>

		<main>
			

			<div class="program-det-page">
				<div class="program-title">
					<h2><?php echo($prog_name_don);?></h2>
				</div>
				<div class="org-name">
					<h3><?php echo($org_name_don);?></h3>
				</div>
				<div class="program-detail">
					<p><?php echo($fetch_pdet_row['prog_details']);?></p>
				</div>
				<div >
					<button class = "donate-button-prg" onclick="location.href='donation.php?prog_id=<?php echo $program_id;?>'" name='go_donation'>Donate <span class='las la-arrow-right'></span></button>
				</div>
			</div>


		</main>

	</div>
</body>