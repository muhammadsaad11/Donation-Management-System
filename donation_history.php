<?php

session_start();
require 'connection.php';
$email = $_SESSION['email'];
$query = "SELECT * FROM user WHERE email = '$email'";
$results = mysqli_query($db, $query);
$user_data_row = mysqli_fetch_assoc($results);
$isVerified = $user_data_row['verify'];
$user_id = $user_data_row['id'];


if(!isset($_SESSION['email']))
{
	$_SESSION['msg'] = "You must log in first to view this page";
	header("location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Donation History</title>
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
				Donation History
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
			
			<div class="card-body">
							<div class="table-responsive">
								<table width="100%">
									<thead>
										<tr>
											<td>Donation</th>
											<td>Program</td>
											<td>Date</td>
											<td>Status</td>
										</tr>
									</thead>
									<tbody>
										<?php  
										$history_query = "SELECT amount, program_id, deposit_date, status FROM donation WHERE user_id = '$user_id' ORDER BY id DESC";
										$result_history = mysqli_query($db, $history_query);
										if (mysqli_num_rows($result_history) > 0)
										{
											while ($hist_row = mysqli_fetch_assoc($result_history))
											{
												$query_program_name = "SELECT program_name FROM programs where id = ".$hist_row['program_id']."";
												$result_prog_name = mysqli_query($db, $query_program_name);
												$prog_name_row = mysqli_fetch_assoc($result_prog_name);
												if($hist_row['status'] == "0")
												{
													echo ("<tr>
														<td>".$hist_row['amount']."</td>
														<td>".$prog_name_row['program_name']."</td>
														<td>".date('Y-m-d',strtotime($hist_row['deposit_date']))."</td>
														<td><span class='status purple'></span>In Process</td>
													  </tr>");
												}
												elseif($hist_row['status'] == "1")
												{
													echo ("<tr>
														<td>".$hist_row['amount']."</td>
														<td>".$prog_name_row['program_name']."</td>
														<td>".date('Y-m-d',strtotime($hist_row['deposit_date']))."</td>
														<td><span class='status green'></span>Reviewed</td>
													  </tr>");
												}
												elseif($hist_row['status'] == "2")
												{
													echo ("<tr>
														<td>".$hist_row['amount']."</td>
														<td>".$prog_name_row['program_name']."</td>
														<td>".date('Y-m-d',strtotime($hist_row['deposit_date']))."</td>
														<td><span class='status pink'></span>Declined</td>
													  </tr>");
												}
											}
										}
										else
										{
											echo ("<tr>
														<td>No</td>
														<td>Donations</td>
														<td>Found</td>
														<td></td>
													  </tr>");
										}

										?>
										
									</tbody>
								</table>
							</div>
						</div>
		</main>

	</div>
</body>