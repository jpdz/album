
<?php session_start(); 
if(isset($_POST['logout'])){
	if (isset($_SESSION['logged_user_by_sql'])) {
		$olduser = $_SESSION['logged_user_by_sql'];
		unset($_SESSION['logged_user_by_sql']);
	} else {
		$olduser = false;
	}
}
?>
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
<div>
<?php
		
		if(isset($_POST['login'])){ 

			
			$post_username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
			$post_password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );

			$query = "SELECT * 
						FROM users
						WHERE
							username = '$post_username'";

			$result = $mysqli->query($query);

			

			if (!$result) {
			print($mysqli->error);
			exit();
			}

			//Make sure there is exactly one user with this username
			if ( $result && $result->num_rows == 1) {
				
				$row = $result->fetch_assoc();
				$db_hash_password = $row['hashpassword'];
				
				if( password_verify( $post_password, $db_hash_password ) ) 
				{
					$db_username = $row['username'];
					$_SESSION['logged_user_by_sql'] = $db_username;
				}
			} 
			
			
			
			
		}
		
  ?>
  </div>
	<header>
		<nav id="topbar">
			<ul>
			<li class="left"><a href="" ><img id="logo" src="img/logo.png" alt=""></a></li> 
			<li class="left"><a href="" ><p>Home</p></a></li>
			<li class="right" id="username"><a href="" >
			
				<?php
				if ( isset($_SESSION['logged_user_by_sql'] ) ) {
					print("<form class = 'log' action='index.php' method='POST'>");
					print("<input type='submit' name='logout' value='logout'>");
					require_once 'includes/addalbum.php';
				}  
				else{
					print("<form class = 'log' action='login.php' method='POST'>");
					print("<input type='submit' name='login' value='login'>");
				}
				?>
				
			</form>
			
			</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<nav id="sidebar">
			<div class="side_module" id="top_space" >
				<a id="sidebar_hide"></a>
			</div>
			<div id="search_module">
				<a id="search_toggle"><h3>Search for images</h3></a>
				<div class="side_module" id="search">
					<form action="search1.php" method="POST">
						<input type="text" name="search_title" placeholder="title">
						<input type="text" name="search_credit" placeholder="credit">
						<input type="text" name="search_album" placeholder="album">
						<input type="submit" name="search_submit" value="search">
					</form>
				</div>
				<hr class="line">
			</div>

			<div id="show_album_module">
				<a id="allalbum_toggle"><h3>All albums</h3></a>
				<div class="side_module"  id="catalog">
				<ul>
				<?php 
					require_once 'includes/deletealbum.php';
					require_once 'includes/showalbum.php';
				?>
				</ul>
				</div>
				<hr class="line">
			</div>

			<?php 
				if ( isset($_SESSION['logged_user_by_sql'] ) ) {
				require_once 'includes/albumlist_admin.php'; 


			} 
				
			?>

		</nav>

		<div id="wrapper">
			<div id="arrow">
			<a id="sidebar_show"></a>
			</div>
			<div class="inner">
				<div class="center">
				<h1>All your great memories are here</h1>
				</div>
				<div class="thumbnails">
				<div class="thumbnails_2">
				<?php
					foreach($albumlist as $album_item){
						
						$album_id = $album_item['albumID'];
						$href = "album.php?album_id=$album_id";
						$href1 = "albumdelete.php?album_id=$album_id";
						print("<div class='small'>");
							print("<div class='smaller'>");
							$imgurl = $album_item['url'];
								print ("<div class = 'all'>");
									print ("<div class = 'begin'>");
										print("<img class='img' src = '$imgurl' alt=''>");
									print( "</div>");

									print( "<div class = 'end'>" );
										
										#print("<a class='button' style='cursor:pointer' href='$href1'>delete</a>");
										/*
										print("<form class='admin' method='POST'>");
										print("<input type='submit' value='delete' name='delete_album'/>");
										print("</form>");
										*/
									print( "</div>");
								print( "</div>");


								print( "<p class='name'><a style='cursor:pointer' href='$href'>{$album_item[ 'title' ]}</a></p>" );
							print("</div>");
						print("</div>");
					}

					#print( "<p>Showing movies using the SQL query <br>$html_safe_sql</p>");
				
					//Loop through the $result rows fetching each one as an associative array
					/*
					while ($row = $result_copy->fetch_assoc()) {
						print('<div class="container">');
						$album_id = $row['albumID'];
						
						$href = "album.php?album_id=$album_id";
						print("<a style='cursor:pointer', href='$href'>");
						$imgurl = $row['url'];
						print("<img class='img' src = '$imgurl' alt=''>");
						print( "<h2 class='title'>{$row[ 'title' ]}</h2>" );
						print("</a>");
						print("</div>");
						#$href = "add-edit.php?movie_id=$movie_id";
						#print("<li><a href='$href' title='$href'>Edit</a></li>");
					}*/


				?>
				</div>
				</div>

			</div>	
		</div>
		
	</main>
	<footer>
	</footer>

</body>
</html>