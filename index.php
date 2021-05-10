<?php
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
			<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our challenge!</h1>
		</div>
		<p>
			<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
			<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
		</p>
	</body>
              <br>
              <body>
                            <div>
                                          <h2>
                                                        You must work your way through this website and find our hidden solution.
                                                        <br>
                                                        There will be many twists and turns but only one correct path!
                                                        <br>
                                                        <br>
                                                        Choose your path wisely!
                                          </h2>
                            </div>
                            <hr>
                            <div>
                                          <a href="fool.php">
                                                        <img src="tarot/fool.png">
                                          </a>
                                          <br>
                                          <a href="magician.php">
                                                        <img src="tarot/magician.png">
                                          </a>
                                          <a href="highpriestess.php">
                                                        <img src="tarot/highpriestess.png">
                                          </a>
                                          <a href="empress.php">
                                                        <img src="tarot/empress.png">
                                          </a>
                                          <a href="emperor.php">
                                                        <img src="tarot/emperor.png">
                                          </a>
                                          <a href="hierophant.php">
                                                        <img src="tarot/hierophant.png">
                                          </a>
                                          <a href="lovers.php">
                                                        <img src="tarot/lovers.png">
                                          </a>
                                          <a href="chariot.php">
                                                        <img src="tarot/chariot.png">
                                          </a>
                                          <a href="strength.php">
                                                        <img src="tarot/strength.png">
                                          </a>
                                          <a href="hermit.php">
                                                        <img src="tarot/hermit.png">
                                          </a>
                                          <a href="wheeloffortune.php">
                                                        <img src="tarot/wheeloffortune.png">
                                          </a>
                                          <a href="justice.php">
                                                        <img src="tarot/justice.png">
                                          </a>
                                          <a href="hangedman.php">
                                                        <img src="tarot/hangedman.png">
                                          </a>
                                          <a href="death.php">
                                                        <img src="tarot/death.png">
                                          </a>
                                          <a href="temperance.php">
                                                        <img src="tarot/temperance.png">
                                          </a>
                                          <a href="devil.php">
                                                        <img src="tarot/devil.png">
                                          </a>
                                          <a href="tower.php">
                                                        <img src="tarot/tower.png">
                                          </a>
                                          <a href="star.php">
                                                        <img src="tarot/star.png">
                                          </a>
                                          <a href="moon.php">
                                                        <img src="tarot/moon.png">
                                          </a>
                                          <a href="sun.php">
                                                        <img src="tarot/sun.png">
                                          </a>
                                          <a href="judgement.php">
                                                        <img src="tarot/judgement.png">
                                          </a>
                                          <a href="world.php">
                                                        <img src="tarot/reverse_world.png">
                                          </a>
                            </div>
              </body>
</html>