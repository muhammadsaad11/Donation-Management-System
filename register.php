<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
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

	<div class="hero-reg">
		<div class="heading-mint heading-mint-reg">
			<h1>Donate & Make This World a Better Place.</h1> <!-- add easyfunds tagline here -->
			<p>Already have an Account? <a href="index.php" class="other-page">Login!</a></p>
		</div>
		<div class="form-box-reg">
			<div><h2 class="form-title">Sign Up</h1></div>
			<form id="sign-up" class="input-group" action="register.php" method="post">   <!--register-->
				<div class="error-msg" style="color:#dd4b39;"><?php include('errors_reg.php') ?></div>
				<div class="input-reg">
					<label for="fname"><b>Full Name:</b></label>
					<input type="text" class="input-field" name="fname" placeholder="Enter Full Name" value="<?php echo $fname; ?>" required>
				</div>
				
				<div class="input-reg">
					<label for="email"><b>Email:</b></label>
					<input type="email" class="input-field" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" required>	
				</div>
				
				<div class="input-reg">
					<label for="password_1"><b>Password:</b></label>
					<input type="password" class="input-field" id="psw" name="password_1" placeholder="Enter Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters">	
				</div>
				
				<!-- validation system for password -->
				<div class="input-reg">
					<div id="message">  
						<h3>Password must contain the following:</h3>
						<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
						<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
						<p id="number" class="invalid">A <b>number</b></p>
						<p id="length" class="invalid">Minimum <b>8 characters</b></p>
					</div>	
				</div>
				

				<div class="input-reg">
					<label for="password_2"><b>Re-enter Password:</b></label>
					<input type="password" class="input-field" name="password_2" placeholder="Confirm password" required>	
				</div>
				
				<div class="input-reg">
					<label for="address"><b>Address:</b></label>
					<input type="text" class="input-field" name="address" placeholder="Enter your Address" value="<?php echo $address; ?>" required>
				</div>

				<div class="input-reg">
					<label for="phone"><b>Phone:</b></label>
					<input type="tel" class = "input-field" name="phone" placeholder="Phone #" value="<?php echo $phone; ?>" required>	
				</div>
				
				<div class="input-reg check-box-reg">
					<span><input type="checkbox" class="check-box" required></span><span>I agree to the <a href="Terms-and-conditions.htm" target="_blank">terms & conditions</a>.</span>	
				</div>
				

				<button type="submit" class="submit-btn" name="reg_user">Sign Up</button>
			</form>
		</div>
	</div>


	<script type="text/javascript">var myInput = document.getElementById("psw");
		var letter = document.getElementById("letter");
		var capital = document.getElementById("capital");
		var number = document.getElementById("number");
		var length = document.getElementById("length");

		// When the user clicks on the password field, show the message box
		myInput.onfocus = function() {
		  document.getElementById("message").style.display = "block";
		}

		// When the user clicks outside of the password field, hide the message box
		myInput.onblur = function() {
		  document.getElementById("message").style.display = "none";
		}

		// When the user starts to type something inside the password field
		myInput.onkeyup = function() {
		  // Validate lowercase letters
		  var lowerCaseLetters = /[a-z]/g;
		  if(myInput.value.match(lowerCaseLetters)) {
		    letter.classList.remove("invalid");
		    letter.classList.add("valid");
		  } else {
		    letter.classList.remove("valid");
		    letter.classList.add("invalid");
		}

		  // Validate capital letters
		  var upperCaseLetters = /[A-Z]/g;
		  if(myInput.value.match(upperCaseLetters)) {
		    capital.classList.remove("invalid");
		    capital.classList.add("valid");
		  } else {
		    capital.classList.remove("valid");
		    capital.classList.add("invalid");
		  }

		  // Validate numbers
		  var numbers = /[0-9]/g;
		  if(myInput.value.match(numbers)) {
		    number.classList.remove("invalid");
		    number.classList.add("valid");
		  } else {
		    number.classList.remove("valid");
		    number.classList.add("invalid");
		  }

		  // Validate length
		  if(myInput.value.length >= 8) {
		    length.classList.remove("invalid");
		    length.classList.add("valid");
		  } else {
		    length.classList.remove("valid");
		    length.classList.add("invalid");
		  }
		}</script>

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