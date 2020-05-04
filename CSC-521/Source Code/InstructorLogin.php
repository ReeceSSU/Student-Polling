<?php
    # Uncomment line below to show any errors
	# ini_set('display_errors', 1);
	
	require 'DatabaseLogin.php';
    session_start();

	if(isset($_POST['username'])){

	    # Sets variables from form
        $_SESSION['uname']=$_POST['username'];
		$_SESSION['password']=$_POST['password'];

		# Checks if username / password is correct
		$query="SELECT * FROM Instructor WHERE Username='".$_SESSION['uname']."'AND Password='".$_SESSION['password']."' LIMIT 1";
		
		$result=mysqli_query($connection, $query);
		
		if(mysqli_num_rows($result)==1){
			echo " You Have Successfully Logged in";
            header("Location: InstructorHome.php");
			exit();
		}
		else {
			echo " You Have Entered Incorrect Password";
			exit();
		}
			
	}
?>

<!DOCTYPE html>

<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			body {font-family: Arial, Helvetica, sans-serif;}
			form {border: 3px solid #f1f1f1;}

			input[type=text], input[type=password] {
			  width: 100%;
			  padding: 12px 20px;
			  margin: 8px 0;
			  display: inline-block;
			  border: 1px solid #ccc;
			  box-sizing: border-box;
			}

			button {
			  background-color: #13a4fd;
			  color: white;
			  padding: 14px 20px;
			  margin: 8px 0;
			  border: none;
			  cursor: pointer;
			  width: 100%;
			}

			button:hover {
			  opacity: 0.8;
			}

			.cancelbtn {
			  width: auto;
			  padding: 10px 18px;
			  background-color: #e72402;
			}

			.imgcontainer {
			  text-align: center;
			  margin: 24px 0 12px 0;
			}

			img.instructor {
			  width: 25%;
			  border-radius: 1%;
			}

			.container {
			  padding: 16px;
			}

			span.psw {
			  float: right;
			  padding-top: 16px;
			}

			/* Change styles for span and cancel button on extra small screens */
			@media screen and (max-width: 300px) {
			  span.psw {
				 display: block;
				 float: none;
			  }
			  .cancelbtn {
				 width: 100%;
			  }
			}
		</style>
	</head>
	<body>

	<h2>Instructor Login Form</h2>

	<form method="POST" action="#">
	  <div class="imgcontainer">
		<img src="Images/img_instructor.png" alt="instrucot" class="instructor">
	  </div>

	  <div class="container">
		<label for="uname"><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="username" required>

		<label for="psw"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" required>
			
		<button type="submit">Login</button>
	  </div>

	  <div class="container" style="background-color:#f1f1f1">
		<a href="Home.php" <button type="button" class="cancelbtn">Cancel</button></a>
		<span class="psw"><a href="#">Forgot Password?</a></span>
	  </div>
	</form>

	</body>
</html>