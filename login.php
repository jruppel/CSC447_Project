<?php

// initialize the session
session_start();

// check if the user is already logged in
// if so, redirect to the welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
	header("location: index.php");
	exit;
}
 
// include the db config file
require_once "config/config.php";
 
// define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	// check if the username is empty
	if (empty(trim($_POST["username"])))
		$username_err = "Please enter username.";

	// check if the password is empty
	if (empty(trim($_POST["password"])))
		$password_err = "Please enter your password.";

	// validate the credentials
	if (empty($username_err) && empty($password_err))
	{
		// prepare a sql statement
		$sql = "SELECT id, username, password FROM users WHERE username = ?";

		if ($stmt = mysqli_prepare($conn, $sql))
		{
			// bind variables to the sql statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			// set parameters
			$param_username = $username;

			// attempt to execute the sql statement
			if (mysqli_stmt_execute($stmt))
			{
				// store the result
				mysqli_stmt_store_result($stmt);

				// check if the username exists
				// if so, verify the password
				if (mysqli_stmt_num_rows($stmt) == 1)
				{
					// bind the result variables
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if (mysqli_stmt_fetch($stmt))
					{
						if (password_verify($password, $hashed_password))
						{
							// the password is correct; start a new session
							session_start();

							// store user data in session variables
							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;

							// redirect the user to the welcome page
							header("location: index.php");
						}
						else
							// display an error message if the password is invalid
							$password_err = "The password you entered was not valid.";
					}
				}
				else
					// display an error message if the username doesn't exist
					$username_err = "No account found with that username.";
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
		<title>Login</title>
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
			<h2>Login</h2>
			<p>Please fill in your credentials to login.</p>
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
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Login">
				</div>
				<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
			</form>
		</div>
	</body>
</html>
