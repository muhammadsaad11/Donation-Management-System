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
	$fetch_program_det = "SELECT program_name, org_name FROM programs WHERE id = '$program_id'";
	$result_fetch_pdet = mysqli_query($db, $fetch_program_det);
	$fetch_pdet_row = mysqli_fetch_assoc($result_fetch_pdet);
	$prog_name_don = $fetch_pdet_row['program_name'];
	$org_name_don = $fetch_pdet_row['org_name'];
}

$amount_donated = 0;
$user_id = $user_data_row['id'];

$donation_success = 0;

$program_id = $_SESSION['prog_id'];

if (isset($_POST['donate_btn']))
{
	$error_file_upload = "";
	$amount_donated = (int)mysqli_real_escape_string($db, $_POST['amount_don']);

	$filename = basename($_FILES['receipt_file']['name']);
	$destination = 'receipts/'.$filename;
	$extension = pathinfo($destination, PATHINFO_EXTENSION);

	$file = $_FILES['receipt_file']['tmp_name'];
    $size = $_FILES['receipt_file']['size'];

    if (!in_array($extension, ['pdf', 'jpg','png','jpeg'])) 
    {
    	$error_file_upload = "Your file extension must be .pdf, .jpg, .png or .jpeg";
    } 
    elseif ($_FILES['receipt_file']['size'] > 1000000)
    { // file shouldn't be larger than 1Megabyte
        $error_file_upload = "File too large!";
    } 
    else 
    {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) 
        {
            $donation_accept_query = "INSERT INTO donation (user_id, amount, program_id, receipt_file_name) VALUES ('$user_id', '$amount_donated', '$program_id', '$filename')";

            if (mysqli_query($db, $donation_accept_query)) 
            {
                $error_file_upload = "Successfully Donated. Waiting for review. You can check the status from donation history section.";
                $donation_success = 1;
            }
        } 
        else 
        {
            $error_file_upload = "Failed to upload file.";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Donate</title>
	<link rel="shortcut icon" href="img/EF8.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard-style.css">
	<link rel="stylesheet" type="text/css" href="css/donation_program_style.css">
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
				Donate
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

				<?php if ($donation_success == 1) : ?>
					<div class="success">
						<p><?php echo($error_file_upload); ?></p>	
					</div>

				
				<?php else: ?>
					<div class="error">
						<p><?php echo($error_file_upload);  ?></p>
					</div>
				<?php endif ?>
				
				<div class="donation-form">
					<h2>Donate</h2>
					<form action="donation.php" method="post" enctype="multipart/form-data">
						<div>
							<div class="input-don">
								<label><b>Program: </b></label> <input class = "input-field" type="text" name="prog_name_don" placeholder="Program Name" value="<?php echo($prog_name_don); ?>"  readonly>
								<!-- add the program name using php as placeholder -->	
							</div>
					
							<div class="input-don">
								<label><b>Offered by: </b></label> <input class = "input-field" type="text" name="org_name_don" placeholder="Organisation Name" value="<?php echo($org_name_don); ?>"  readonly>	
							</div>
							
							<div class="input-don">
								<label><b>Amount: </b></label> <input class = "input-field" type="number" name="amount_don" placeholder="Enter Amount"  required>	
							</div>
							
							<div class="input-don don-receipt-file">
								<label><b>Upload Receipt: </b></label><input class="inputfile" type="file" name="receipt_file" required>
							</div>

							<div class="input-don check-box-don">
								<span><input type="checkbox" class="check-box" required></span><span>I agree to the <a href="Terms-and-conditions.htm" target="_blank">terms & conditions</a>.</span>	
							</div>

							<button type="submit" class="donate-btn" name="donate_btn"> Confirm Donation <span class='las la-donate'></span></button>

						</div>
					</form>
				</div>

				<div class="payment-options">
					<h4>Step1: Donate the amount in any given account below.</h4>
					<h4>Step2: Enter the amount in the form above and upload the transaction receipt.</h4>
					<h4>Step3: Press Confirm donation button, then your donation would be sent for review.</h4>
					
					<div class="jazz-cash-account">
						<div>
							<img src="img/jazz-cash-logo.svg">	
						</div>
						<div>
							<label><b>Account Title:</b> Syed Danish Hasan</label>	
						</div>
						<div>
							<label><b>Account Number:</b> 0315-8560713</label>	
						</div>
						
					</div>
					<div class="easypaisa-account">
						<div>
							<img src="img/easypaisa-logo.png">	
						</div>
						<div>
							<label><b>Account Title:</b> Muhammad Saad</label>	
						</div>
						<div>
							<label><b>Account Number:</b> 0305-3404740</label>	
						</div>
						
					</div>
					
				</div>
			</div>
		</main>

	</div>
</body>