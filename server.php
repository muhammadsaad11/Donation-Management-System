<?php 


session_start();
require 'connection.php';
$username = "";
$email = "";
$phone = "";
$address = "";
$fname = "";

$errors = array();    //errors array for registration module

$errors_login = array();   //errors array for login module


//for the email delivery
require ('PHPMailer/PHPMailerAutoload.php');

//register users

if (isset($_POST['reg_user']))
{

	$fname = mysqli_real_escape_string($db, $_POST['fname']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
	$address = mysqli_real_escape_string($db, $_POST['address']);
	$phone = mysqli_real_escape_string($db, $_POST['phone']);
	$v_token = md5(time().$email);
	$verify = 0;
	$datej = date('Y-m-d');


	//form validation
	if (empty($email)) {array_push($errors, "Email is required.");}
	if (empty($password_1)) {array_push($errors, "Password is required.");}
	if (empty($address)) {array_push($errors, "Address is required.");}
	if (empty($phone)) {array_push($errors, "Phone number is required.");}

	//checking if the passwords enter in both fields same
	if($password_1 != $password_2) {array_push($errors, "Passwords do not match.");}


	$user_check_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";

	$results = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($results);


	if($user)
	{
		if ($user['email'] === $email){array_push($errors, "This email id already exists.");}

	}

	//register the user if there are no errors

	if (count($errors) == 0)
	{
		$password = password_hash($password_1, PASSWORD_DEFAULT);  //encrypting the password
		$query = "INSERT INTO user (fname, email, password, phone, address, vtoken, verify) VALUES ('$fname', '$email', '$password', '$phone', '$address', '$v_token', '$verify')";
		mysqli_query($db, $query);
		$_SESSION['email'] = $email;
      	$_SESSION['v_token'] = $v_token;
		$query = "SELECT * FROM user WHERE email = '$email'";
		$results = mysqli_query($db, $query);


		//____________________phpmailer code for verification email sending_____________________________________
		if ($results == true)
		{
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
			$mail->Body    = '<p>Hi User,<br>We are happy that you signed up for EasyFunds. Your choice to make this world a better place by donating to our programs is praiseworthy. To start using the EasyFunds platform, please confirm your email address. Click the link below to verify:</p> <p><a href="http://localhost/se-project/verify.php?token='.$v_token.'"> Link for verification </a><br></p> <p>Welcome to EasyFunds, <br>The EasyFunds Team';
			// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			// $mail->Body    = '<p>Hi User,<br>We are happy that you signed up for EasyFunds. Your choice to make this world a better place by donating to our programs is praiseworthy. To start using the EasyFunds platform, please confirm your email address. Click the link below to verify:</p> <p><a href="http://easyfunds.atwebpages.com/verify.php?token='.$v_token.'"> Link for verification </a><br></p> <p>Welcome to EasyFunds, <br>The EasyFunds Team';
			
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    $msg = "Verification email sent";
			}
		//_____________________________________________________________________



		//____________________phpmailer code for WELCOME email sending_____________________________________
			$mail2 = new PHPMailer;

			//$mail->SMTPDebug = 3;                               // Enable verbose debug output

			$mail2->isSMTP();                                      // Set mailer to use SMTP
			$mail2->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail2->SMTPAuth = true;                               // Enable SMTP authentication
			$mail2->Username = 'easyfunds112@gmail.com';                 // SMTP username
			$mail2->Password = 'Se-project$$';                           // SMTP password
			$mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail2->Port = 587;                                    // TCP port to connect to

			$mail2->setFrom('easyfunds112@gmail.com', 'EasyFunds');
			$mail2->addAddress($email, 'User');     // Add a recipient
			$mail2->isHTML(true);                                  // Set email format to HTML

			$mail2->Subject = 'Welcome to EasyFunds!';
			$mail2->Body    = '<p>Hi User,<br> <br>Welcome to the EasyFunds Community.<br><br>We look forward to a long fruitful partnership. Stay prospering!</p><p>Your friends at EasyFunds!</p>';
			// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients";

			if(!$mail2->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail2->ErrorInfo;
			} else {
			    $msg2 = "Welcome email sent";
			}
		}
		//_____________________________________________________________________




		$user_data_row = mysqli_fetch_assoc($results);
		$_SESSION['fname'] = $user_data_row['fname'];
		$_SESSION['phone'] = $user_data_row['phone'];
		$_SESSION['address'] = $user_data_row['address'];
		$_SESSION['datejoined'] = $user_data_row['datejoined'];
		$_SESSION['success'] = "You are now logged in";

		header('location: dashboard.php');
	}
}

//login the user

if (isset($_POST['login_user']))
{
	$email = mysqli_real_escape_string($db, $_POST['email1']);
	$password = mysqli_real_escape_string($db, $_POST['password1']);

	if(empty($email))
	{
		array_push($errors_login, 'Email is required.');
	}
	if(empty($password))
	{
		array_push($errors_login, 'Password is required.');
	}

	if(count($errors_login) == 0)
	{
		$query = "SELECT * FROM user WHERE email = '$email'";

		$results = mysqli_query($db, $query);
		$user_data_row = mysqli_fetch_assoc($results);
		if(!$user_data_row)
		{
			array_push($errors_login, "This email does not exist.");
		}
		else
		{
			if(password_verify($password, $user_data_row['password']))
			{
				$_SESSION['fname'] = $user_data_row['fname'];
				$_SESSION['email'] = $email;
				$_SESSION['phone'] = $user_data_row['phone'];
				$_SESSION['address'] = $user_data_row['address'];
				$_SESSION['datejoined'] = $user_data_row['datejoined'];
				$_SESSION['v_token'] = $user_data_row['vtoken'];
				$_SESSION['success'] = "Logged in successfully";
				header('location: dashboard.php');

			}
			else
			{
				array_push($errors_login, "Wrong Email or Password, Please try again.");
			}	
		}
	}
}

?>


