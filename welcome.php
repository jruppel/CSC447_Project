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

?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Welcome</title>
		<link rel="stylesheet" href="bootstrap.css">
		<style type="text/css">
			body
			{
				font: 14px sans-serif;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="page-header">
			<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
		</div>
		<p>
			<a href="chat-channels.php" class="btn btn-primary">Chat Channels</a>
			<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
			<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
		</p>
	</body>
</html>
