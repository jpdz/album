<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Main Page</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<?php 
		require_once "includes/functions.php";
		add_versioned_file( 'scripts/main.js', 'JavaScript' );
		add_versioned_file( 'style/main.css', 'Style' );
	?>
</head>
	<?php
		
		//Get the connection info for the DB. 
		require_once 'includes/config.php';
		
		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}
	?>
<body>
	<header>
		<nav id="topbar">
			<ul>
			<li class="left"><a href="" ><img id="logo" src="img/logo.png" alt=""></a></li> 
			<li class="left"><a href="" ><p>Home</p></a></li>
			<li class="right"><a href="" ><p>usermane</p></a></li>
			</ul>
		</nav>
	</header>
	<main>
		
		<div class="center">
		<h1>Login to Manage the albums</h1>
		</div>
		<div class="text">
		
			<form action="index.php" method="post">
				<input type="text" name="username" placeholder="username"> 
				<input type="password" name="password" placeholder="password"> 
				<input type="submit" name="login" value="login">
			</form>
		</div>
		
	</main>
	</body>
	</html>
	