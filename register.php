<?php

// include the db config file
require_once "config/config.php";
 
// define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	// first, validate the username
	if (empty(trim($_POST["username"])))
		$username_err = "Please enter a username.";
	else
	{
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_password = trim($_POST["confirm_password"]);

		// prepare a sql statement
		$sql = "SELECT id FROM users WHERE username = ?";

		if ($stmt = mysqli_prepare($conn, $sql))
		{
			// bind variables to the sql statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			// set parameters
			$param_username = $username;

			// attempt to execute the sql statement
			if (mysqli_stmt_execute($stmt))
			{
				// store the query result
				mysqli_stmt_store_result($stmt);

				if (mysqli_stmt_num_rows($stmt) == 1)
					$username_err = "This username is already taken.";
			}
			else
				echo "Oops!  Something went wrong.  Please try again later.";
		}

		// close the sql statement
		mysqli_stmt_close($stmt);
	}

	// next, validate the password
	if (empty(trim($_POST["password"])))
		$password_err = "Please enter a password.";
	elseif (strlen(trim($_POST["password"])) < 6)
		$password_err = "Password must have at least 6 characters.";
	else
		$password = trim($_POST["password"]);

	// then, validate password confirmation
	if (empty(trim($_POST["confirm_password"])))
		$confirm_password_err = "Please confirm your password.";
	else
	{
		$confirm_password = trim($_POST["confirm_password"]);
		if (empty($password_err) && ($password != $confirm_password))
			$confirm_password_err = "Password did not match.";
	}

	// check for input errors before inserting data into the database
	if (empty($username_err) && empty($password_err) && empty($confirm_password_err))
	{
		// prepare a sql statement
		$sql = "INSERT INTO users (username, password) VALUES (?, ?)";

		if ($stmt = mysqli_prepare($conn, $sql))
		{
			// bind variables to the sql statement as parameters
			mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

			// set parameters
			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT);

			// attempt to execute the sql statement
			if (mysqli_stmt_execute($stmt))
				// redirect to the login page
				header("location: login.php");
			else
				echo "Oops!  Something went wrong.  Please try again later.";
		}

		// close the sql statement
		mysqli_stmt_close($stmt);
	}

	// close the db connection
	mysqli_close($conn);
}

?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Sign Up</title>
		<link rel="stylesheet" href="bootstrap.css">
		<style type="text/css">
			body
			{
				font: 14px sans-serif;
			}
			.wrapper
			{
				width: 350px;
				padding: 20px;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<h2>Sign Up</h2>
			<p>Please fill this form to create an account.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Username</label>
					<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Password</label>
					<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<label>Confirm Password</label>
					<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Submit">
					<input type="reset" class="btn btn-default" value="Reset">
				</div>
				<p>Already have an account?  <a href="login.php">Login here</a>.</p>
			</form>
		</div>
	</body>
</html>
