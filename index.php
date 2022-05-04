<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="shortcut icon" href="img/EF8.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/style2.css">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'> <!-- font "Source Sans Pro" -->
	<link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'> <!-- font "Playfair Display" -->
	<link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>
	<div class="header">
		<div class="header-logo">
			<a href="index.php"><img id="logo-header" src="img/EF7.png"></a>
		</div>
		<div class="header-left" id="myTopnav">
		</div>

		<div class="header-right" id="myTopnav2">
			<a href="register.php" class="header-link">Sign Up</a>
			<a href="index.php" class="header-link">Sign In</a>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		    <span id="bar-hamburger" class="las la-bars"></span>
		  </a>
		</div>
	</div>
		
	<div class="hero-log">
		<div class="heading-mint">
			<h1>Donate & Make This World a Better Place.</h1> <!-- easy funds tag line -->
			<p>Need an account? <a href="register.php" class="other-page">Sign Up!</a></p>
		</div>
		<div class="form-box">
			<div><h2 class="form-title">SignIn</h2></div>
			<form id="login" class="input-group" action="index.php" method="post">   <!--login-->
				<div class="error-msg" style="color:#dd4b39"><?php include('errors_login.php') ?></div>
				<div class="email-input">
					<label for="email1"><b>Email:</b></label>
					<input type="text" class="input-field" name="email1" placeholder="Enter Email" value="<?php echo $email; ?>" required>	
				</div>
				<div class="password-input">
					<label for="password1"><b>Password:</b></label>
					<input type="password" class="input-field" name="password1" placeholder="Enter Password" required>
				</div>
				<button type="submit" class="submit-btn" name="login_user">Login</button>
			</form>
		</div>
	</div>


	<script>
		function myFunction() {
	  var y = document.getElementById("myTopnav2");
	  var x = document.getElementById("myTopnav");
	  if (y.className === "header-right") {
	    y.className += " responsive";
	  } else {
	    y.className = "header-right";
	  }
	  if (x.className === "header-left") {
	    x.className += " responsive2";
	  } else {
	    x.className = "header-left";
	  }
	}
	</script>
</body>

<footer>
	<div class="content">
		<div class="top">
			<div class="logo-details">
				<span class="logo_name">EasyFunds</span>
			</div>
			<div class="media-icons">
				<a href="#" target="_blank"><i class="icon-facebook"></i></a>
				<a href="#" target="_blank"><i class="icon-twitter"></i></a>
				<a href="#" target="_blank"><i class="icon-instagram"></i></a>
				<a href="#" target="_blank"><i class="icon-linkedin"></i></a>
			</div>
		</div>
		<div class="link-boxes">
			<ul class="box">
				<li class="link_name">About</li>
				<li><a href="#">About EasyFunds</a></li>
				<li><a href="#">Services</a></li>
			</ul>
			<ul class="box">
				<li class="link_name">Services</li>
				<li><a href="#">Donation Programs</a></li>
				<li><a href="#">View Donation History</a></li>
				<!-- <li><a href="#">Collect Reward</a></li> -->
			
			</ul>
			<ul class="box">
				<li class="link_name">Customer Service</li>
				<li><a href="#">Help</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">Language</a></li>
			
			</ul>

			
	
	
	
		</div>
	</div>
	    <div class="bottom-details">
      <div class="bottom_text">
        <span class="copyright_text">Copyright © 2022 <a href="#">EasyFunds.</a></span>
        <span class="policy_terms">
          <a href="Terms-and-conditions.htm" target="_blank">Terms & Conditions</a>
          
        </span>
      </div>
    </div>
</footer>
</html>