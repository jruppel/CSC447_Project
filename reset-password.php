<?php

// initialize the session
session_start();
 
// check if the user is logged in
// if not, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	header("location: login.php");
	exit;
}
 
// include the config file
require_once "config/config.php";
 
// define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$new_password = trim($_POST["new_password"]);
	$confirm_password = trim($_POST["confirm_password"]);

	// validate the new password
	if (empty(trim($_POST["new_password"])))
		$new_password_err = "Please enter the new password.";
	elseif (strlen(trim($_POST["new_password"])) < 6)
		$new_password_err = "Password must have at least 6 characters.";

	// validate the password confirmation
	if (empty(trim($_POST["confirm_password"])))
		$confirm_password_err = "Please confirm the password.";
	else
	{
		if (empty($new_password_err) && ($new_password != $confirm_password))
			$confirm_password_err = "Passwords did not match.";
	}

	// check for input errors before updating the database
	if (empty($new_password_err) && empty($confirm_password_err))
	{
		// prepare an sql statement
		$sql = "UPDATE users SET password = ? WHERE id = ?";

		if ($stmt = mysqli_prepare($conn, $sql))
		{
			// bind variables to the sql statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

			// set parameters
			$param_password = password_hash($new_password, PASSWORD_DEFAULT);
			$param_id = $_SESSION["id"];

			// attempt to execute the sql statement
			if (mysqli_stmt_execute($stmt))
			{
				// the password was updated successfully
				// destroy the session and redirect to the login page
				session_destroy();
				header("location: login.php");
				exit();
			}
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
		<title>Reset Password</title>
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
			<h2>Reset Password</h2>
			<p>Please fill out this form to reset your password.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
					<label>New Password</label>
					<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
					<span class="help-block"><?php echo $new_password_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<label>Confirm Password</label>
					<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Submit">
					<a class="btn btn-link" href="index.php">Cancel</a>
				</div>
			</form>
		</div>
	</body>
</html>
