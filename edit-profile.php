<?php

session_start();
require 'connection.php';
$email = $_SESSION['email'];
$v_token = $_SESSION['v_token'];
$query = "SELECT * FROM user WHERE email = '$email'";
$results = mysqli_query($db, $query);
$user_data_row = mysqli_fetch_assoc($results);
$isVerified = $user_data_row['verify'];
$update_address = $user_data_row['address'];
$update_phone = $user_data_row['phone'];
$update_fname = $user_data_row['fname'];
$updated = 0;
if(!isset($_SESSION['email']))
{
	$_SESSION['msg'] = "You must log in first to view this page";
	header("location: index.php");
}

if (isset($_POST['save_data']))
{
	$update_fname = mysqli_real_escape_string($db, $_POST['name-edit']);
	$update_address = mysqli_real_escape_string($db, $_POST['address-edit']);
	$update_phone = mysqli_real_escape_string($db, $_POST['phone-edit']);
	$query = "UPDATE user SET fname = '$update_fname', address= '$update_address', phone= '$update_phone' WHERE email = '$email';";
	mysqli_query($db, $query);
	$query = "SELECT * FROM user WHERE email = '$email'";
	$results = mysqli_query($db, $query);
	$user_data_row = mysqli_fetch_assoc($results);
	$_SESSION['fname'] = $user_data_row['fname'];
	$_SESSION['phone'] = $user_data_row['phone'];
	$_SESSION['address'] = $user_data_row['address'];
	$updated = 1;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Edit Profile</title>
	<link rel="shortcut icon" href="img/EF8.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard-style.css">
	<link rel="stylesheet" type="text/css" href="css/profile-edit.css">
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

				<li><a href="#" class="active"><span class="las la-user-circle"></span><span>Account</span></a>
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
				Account
			</h2>

			<div class="search-wrapper">
				<span class="las la-search"></span>
				<input type="search" placeholder="Search here"/>
			</div>

			<div class="user-wrapper">
				<img src="img/picture-not-present.jpg" width="40px" height="40px" alt="">
				<div>
					<h4><?php echo $_SESSION['fname']; ?></h4>
					<small>User</small>
				</div>
			</div>
		</header>

		<main>
			<div class="edit-profile">
				<?php if ($updated == 1) : ?>
					<div class="success">
						<p>Successfully updated the data.</p>	
					</div>
				<?php endif ?>
				
				<div class="edit-form">
					<h2>Edit Your Profile</h2>
					 <form id="edit-data" class="input-group" action="edit-profile.php" method="post">   <!--login -->
						<div class="input-edit email-display">
							<label for="email1"><b>Email: </b></label>
							<input type="text" class="input-field" placeholder="Email" value="<?php echo $email; ?>" readonly>	
							<!-- <input type="text"><?php echo $email; ?></input> -->

						</div>
						<div class="input-edit username-edit">
							<label for="name-edit"><b>Full Name:</b></label>
							<input type="text" class="input-field" name="name-edit" placeholder="Enter Full Name" value="<?php echo $update_fname; ?>" required>	
						</div>
						<div class="input-edit address-edit">
							<label for="address-edit"><b>Address:</b></label>
							<input type="text" class="input-field" name="address-edit" placeholder="Enter Address" value="<?php echo $update_address; ?>" required>	
						</div>
						<div class="input-edit phone-edit">
							<label for="phone-edit"><b>Phone:</b></label>
							<input type="text" class="input-field" name="phone-edit" placeholder="Enter Phone Number" value="<?php echo $update_phone; ?>" required>	
						</div>
						<button type="submit" class="save-btn" name="save_data"><span class="las la-save"></span> Save</button>
					</form>
				</div>
			</div>
		</main>

	</div>
</body>