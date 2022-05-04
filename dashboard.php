<?php

session_start();
require 'connection.php';
$email = $_SESSION['email'];
$v_token = $_SESSION['v_token'];
$query = "SELECT * FROM user WHERE email = '$email'";
$results = mysqli_query($db, $query);
$user_data_row = mysqli_fetch_assoc($results);
$isVerified = $user_data_row['verify'];
$user_id = $user_data_row['id'];


// total amount donated for card on dashboard
$total_amount_don = 0;
$total_amount_don_query = "SELECT sum(amount) as total_amount FROM donation WHERE user_id = '$user_id'";
$result_total_amt = mysqli_query($db, $total_amount_don_query);
$total_amt_row = mysqli_fetch_assoc($result_total_amt);
$total_amount_don = $total_amt_row['total_amount'];


// total number of programs donated in
$total_programs_don = 0;
$total_programs_don_query = "SELECT count(*) as num_prog FROM donation WHERE user_id = '$user_id'";
$result_total_prog = mysqli_query($db, $total_programs_don_query);
$total_prog_row = mysqli_fetch_assoc($result_total_prog);
$total_programs_don = $total_prog_row['num_prog'];


// average amount donated for card on dashboard
$average_amount_don = 0;
$average_amt_don_query = "SELECT ROUND(AVG(amount),1) as avg_amount FROM donation WHERE user_id = '$user_id'";
$result_avg_amt = mysqli_query($db, $average_amt_don_query);
$avg_amt_row = mysqli_fetch_assoc($result_avg_amt);
$average_amount_don = $avg_amt_row['avg_amount'];

if(!isset($_SESSION['email']))
{
	$_SESSION['msg'] = "You must log in first to view this page";
	header("location: index.php");
}




require ('PHPMailer/PHPMailerAutoload.php');

if(isset($_POST['send-verif-email'])) {
    $mail = new PHPMailer();

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'easyfunds112@gmail.com';                 // SMTP username
	$mail->Password = 'Se-project$$';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('easyfunds112@gmail.com', 'EasyFunds');
	$mail->addAddress($email, 'User');     // Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Confirm your email';
	$mail->Body    = '<p>Hi User,<br>We are happy that you signed up for EasyFunds. Your choice to make this world a better place by donating to our programs is praiseworthy. To start using the EasyFunds platform, please confirm your email address. Click the link below to verify:</p> <p><a href="http://localhost/se-project5/verify.php?token='.$v_token.'"> Link for verification </a><br></p> <p>Welcome to EasyFunds, <br>The EasyFunds Team';

	// $mail->Body    = '<p>Hi User,<br>We are happy that you signed up for EasyFunds. Your choice to make this world a better place by donating to our programs is praiseworthy. To start using the EasyFunds platform, please confirm your email address. Click the link below to verify:</p> <p><a href="http://easyfunds.atwebpages.com/verify.php?token='.$v_token.'"> Link for verification </a><br></p> <p>Welcome to EasyFunds, <br>The EasyFunds Team';
	
	// http://easyfunds.atwebpages.com/dashboard.php



	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    $msg = "Verification email sent";
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>User Dashboard</title>
	<link rel="shortcut icon" href="img/EF8.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard-style.css">
</head>
<body>
	<input type="checkbox" id="nav-toggle">
	<div class="sidebar">
		<div class="sidebar-brand">
			<h2><span><img src="img/EF9.png"></span><span>EasyFunds</span></h2>
		</div>

		<div class="sidebar-menu">
			<ul>
				<li><a href="#" class="active"><span class="las la-igloo"></span><span>Dashboard</span></a>
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
				Dashboard
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
			<div class="cards">
				<div class="cards-single">
					<div>
						<h1><?php echo $total_amount_don; ?></h1>
						<span>Amount Donated</span>
					</div>
					<div>
						<span class="las la-money-bill"></span>
					</div>
				</div>

				<div class="cards-single">
					<div>
						<h1><?php echo $total_programs_don; ?></h1>
						<span>Programs Donated</span>
					</div>
					<div>
						<span class="las la-archive"></span>
					</div>
				</div>

				<div class="cards-single">
					<div>
						<h1><?php echo $average_amount_don; ?></h1>
						<span>Avg Donation</span>
					</div>
					<div>
						<span class="las la-donate"></span>
					</div>
				</div>

				<div class="cards-single">
					<?php 
					$now = time();
					$join_date = strtotime($_SESSION['datejoined']);
					$datediff = $now - $join_date;
					$dsj = round($datediff / (60 * 60 * 24));
					?>
					<div>
						<h1><?php echo($dsj) ?></h1>
						<span>Days since joined</span>
					</div>
					<div>
						<span class="las la-calendar"></span>
					</div>
				</div>
			</div>

			<div class="recent-grid">
				<div class="projects">
					<div class="card">
						<div class="card-header">
							<h3>Donation History</h3>
							<button onclick="location.href='donation_history.php'">See all <span class="las la-arrow-right"></span></button>
						</div>
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
										// echo ($user_id);
										$history_query = "SELECT amount, program_id, deposit_date, status FROM donation WHERE user_id = '$user_id' ORDER BY id DESC";
										$result_history = mysqli_query($db, $history_query);
										if (mysqli_num_rows($result_history) > 0)
										{
											$counter_hist = 0;
											while (($hist_row = mysqli_fetch_assoc($result_history)) && ($counter_hist <4))
											{
												$counter_hist += 1;
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
					</div>
				</div>
				<div class="customers">
					<div class="card">
						<div class="card-header">
							<h3>Profile</h3>
							<button onclick="window.location.href='edit-profile.php';">Edit <span class="las la-edit"></span></button>
						</div>
						<div class="card-body">
							<div class="customer">

								<div class="info">
									<img src="img/picture-not-present.jpg" width="70px" height="70px" alt="image of the user">	
									<div>
										<h3><?php echo $_SESSION['fname']; ?></h3>
										<small>User</small>
									</div>
								</div>
								<div class="details-user">
									<div class="det-email">
										<span class="las la-at"></span><span><?php echo ($_SESSION['email']); ?></span>
									</div>
									<div class="det-phone">
										<span class="las la-phone"></span><span><?php echo ucwords($_SESSION['phone']); ?></span>	
									</div>
									<div class="det-address">
										<span class="las la-map-marked-alt"></span><span><?php echo ucwords($_SESSION['address']); ?></span>
									</div>


									<div id="verification-notice">
										<?php if ($isVerified == 0) : ?>
										<p>Your account is not verified. Please follow the verification email sent to you at <?php echo($_SESSION['email']); ?>.</p>
										<!-- <button class="send-verif">Send Verification email again</button> -->
										<form method="post">
											<input class="send-verif" type="submit" name="send-verif-email" value="Re-send verification email"/>	
										</form>
										
										<?php endif ?>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</main>

	</div>
</body>