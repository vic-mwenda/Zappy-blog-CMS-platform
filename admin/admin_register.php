<?php
 require __DIR__.'/includes/connection.php';
 include '../google_auth.php';


if (isset($_POST['add'])) {
	include "../GUMP-master/gump.class.php";
	$gump = new GUMP();
	$_POST = $gump->sanitize($_POST);

	$gump->validation_rules(array(
		'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
		'firstname'   => 'required|alpha|max_len,30|min_len,2',
		'lastname'    => 'required|alpha|max_len,30|min_len,1',
		'email'       => 'required|valid_email',
		'password'    => 'required|max_len,50|min_len,6',
	));
	$gump->filter_rules(array(
		'username' => 'trim|sanitize_string',
		'firstname' => 'trim|sanitize_string',
		'lastname' => 'trim|sanitize_string',
		'password' => 'trim',
		'email'    => 'trim|sanitize_email',
	));
	$validated_data = $gump->run($_POST);

	if($validated_data === false) {
		?>
		<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
		<?php
	}
	else if ($_POST['password'] !== $_POST['cpassword'])
	{
		echo  "<center><font color='red'>Passwords do not match </font></center>";
	}
	else {
		$username = $validated_data['username'];
		$firstname = $validated_data['firstname'];
		$lastname = $validated_data['lastname'];
		$email = $validated_data['email'];
		$role = $_POST['role'];
		$pass = $validated_data['password'];
		$password = password_hash("$pass" , PASSWORD_DEFAULT);
		$query = "INSERT INTO users(username,firstname,lastname,email,password,role) VALUES ('$username' , '$firstname' , '$lastname' , '$email', '$password' , '$role')";
		$result = mysqli_query($conn , $query) or die(mysqli_error($conn));
		if (mysqli_affected_rows($conn) > 0) {

			echo "<script>alert('REGISTERED SUCCESSFULLY');
      	window.location.href='../email-confirmation.php';</script>";

			//send verification email
			$hash =md5(rand(1000,5000));

			$to      = $email; // Send email to our user
			$subject = 'Signup | Verification'; // Give the email a subject
			$message = '
  Thanks for signing up!Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
  ------------------------
  Username: '.$username.'
  Password: '.$password.'
  ------------------------

  Please click this link to activate your account:
  http://localhost/Zappy/verify.php?email='.$email.'&hash='.$hash.''; // Our message above including the link

			$headers = 'From:noreply@localhost' . "\r\n"; // Set from headers
			mail($to, $subject, $message, $headers); // Send our email
		}
		else {
			echo "<script> alert('An error occured, Try again!'); </script>";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
	<style media="screen">
		*,
		*:before,
		*:after{
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
		body{
			background-color: #dddddd;
		}
		.background{
			width: 430px;
			height: 520px;
			position: absolute;
			transform: translate(-50%,-50%);
			left: 50%;
			top: 50%;
		}
		.background .shape{
			height: 200px;
			width: 200px;
			position: absolute;
			border-radius: 50%;
		}
		.shape:first-child{
			background:#000000;
			left: -100px;
			top: -200px;
		}
		.shape:last-child{
			background:#6C63FF;
			right: -70px;
			bottom: -300px;
		}
		@media (max-width: 738px) {
			.shape{
				display: none;
			}
			form{
				height:800px;
				background-color: #dddddd;

			}
		}


		form{
			margin-top: 50px;
			height: 100%;
			width: 400px;
			background-color: rgba(255,255,255,0.13);
			position: absolute;
			transform: translate(-50%,-50%);
			top: 50%;
			left: 50%;
			border-radius: 10px;
			backdrop-filter: blur(10px);
			border: 2px solid rgba(255,255,255,0.1);
			box-shadow: 0 0 40px rgba(8,7,16,0.6);
			padding: 50px 35px;
		}
		form *{
			font-family: 'EB Garamond', serif;
			color: #1e1e1e;
			letter-spacing: 0.5px;
			outline: none;
			border: none;
		}

		form h2{
			font-size: 30px;
			font-weight: 700;
			color: #212529;
			text-align: center;
		}
		form h3{
			font-size: 32px;
			font-weight: 500;
			line-height: 42px;
			text-align: center;
		}

		label{
			display: block;
			margin-top: 30px;
			font-size: 16px;
			font-weight: 500;
		}
		input{
			display: block;
			height: 50px;
			width: 100%;
			background-color: rgba(55, 55, 55, 0.14);
			border-radius: 3px;
			padding: 0 10px;
			margin-top: 8px;
			font-size: 14px;
			font-weight: 300;
		}
		::placeholder{
			color: #1e1e1e;
		}
		button{
			margin-top: 50px;
			width: 100%;
			background-color: #ffffff;
			color: #080710;
			padding: 15px 0;
			font-size: 18px;
			font-weight: 600;
			border-radius: 5px;
			cursor: pointer;
		}
		.social{
			margin-top: 30px;
			margin-bottom: 50px;
			display: flex;
		}
		.social div{
			background: red;
			width: 150px;
			border-radius: 3px;
			padding: 5px 10px 10px 5px;
			background-color: rgba(255,255,255,0.27);
			color: #1e1e1e;
			text-align: center;
		}
		.social div:hover{
			background-color: rgba(255,255,255,0.47);
		}
		.social .fb{
			margin-left: 25px;
		}
		.social i{
			margin-right: 4px;
		}
		}

	</style>
</head>
<body>
<div class="background">
	<div class="shape"></div>
	<div class="shape"></div>
</div>
<form method="POST" action="" enctype="multipart/form-data">

	<a href="../index.php?"><h2>ZAPPY</h2></a>

	<label for="user_title">User Name</label>
	<input type="text" name="username" class="form-control" required>

	<label for="user_author">FirstName</label>
	<input type="text" name="firstname" class="form-control" required>

	<label for="user_status">LastName</label>
	<input type="text" name="lastname" class="form-control" required>

	<select class="form-control" name="role" id="">
		<label for="user_role">Role</label>
		<?php
		echo "<option value='user'>User</option>";
		?>

	</select>
	<label for="user_tag">Email</label>
	<input type="email" name="email" class="form-control" required>

	<label for="user_tag">Password</label>
	<input type="password" name="password" class="form-control" required>

	<label for="user_tag">Confirm Password</label>
	<input type="password" name="cpassword" class="form-control" required>

	<button type="submit" name="add" class="btn btn-primary" value="Add User">Register</button>

	<a href="index.php" style="margin-top: 40px;text-align: center">Have account. <span>Login now?</span> </a>

	<div class="social">
		<div class="go"><a href="<?php echo $client->createAuthUrl()?>"><i class="fab fa-google" style="color: red"></i>  Google</a></div>
		<div class="fb"><i class="fab fa-facebook" style="color: blue"></i>  Facebook</div>
	</div>
</form>
</body>
</html>
