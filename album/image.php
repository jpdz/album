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

		$img_id = filter_input( INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT );

		//Get the connection info for the DB. 
		require_once 'includes/config.php';
		
		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		require_once 'includes/editimage.php';
		//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}

		$sql_ablum = 'SELECT * from Albums';
		
		$sql_this_img = "SELECT * from Images
		where imageID = '$img_id' ";

		$sql_relate_album = "SELECT albumID from Enrollment where imageID = '$img_id'";

		
		$result = $mysqli->query($sql_ablum);
		if (!$result) {
			print($mysqli->error);
			exit();
		}

		$img_result = $mysqli->query($sql_this_img);
		$img_result2 = $mysqli->query($sql_this_img);

		if (!$img_result) {
			print($mysqli->error);
			exit();
		}

		$album_result = $mysqli->query($sql_relate_album);
		
		if (!$album_result) {
			print($mysqli->error);
			exit();
		}
		//If no result, print the error

		
	?>
<body>
	<header>
		<nav id="topbar">
			<ul>
			<li class="left"><a href="index.php" ><img id="logo" src="img/logo.png" alt=""></a></li> 
			<li class="left"><a href="index.php" ><p>Home</p></a></li>
			<li class="right" id="username"><a href="" >
			
				<?php
				if ( isset($_SESSION['logged_user_by_sql'] ) ) {
					print("<form class = 'log' action='index.php' method='POST'>");
					print("<input type='submit' name='logout' value='logout'>");
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
					require_once 'includes/showalbum.php';
				?>
				</ul>
				</div>
				<hr class="line">
			</div>

			<div id="add_album_module" class="admin">
				<a id="addalbum_toggle"><h3>Details</h3></a>
				<div class = "side_module" id="add_album">
				<?php 
				 	while($row = $img_result2->fetch_assoc()){
						$title = $row['title'];
						$credit =$row['credit'];
					}
					$all_list = array();
					while($row = $album_result->fetch_row()){
						$check = $row[0];
						$album_sql = "SELECT title from Albums where albumID = '$check'";
						$album_res = $mysqli->query($album_sql);
				
						if(!$album_res){
							print($mysqli->error);
							exit();
						}
				
						$temp_album_id = 0;
						while ($row = $album_res->fetch_row()){
							$temp_album_id = $row[0];
							$all_list[] = $temp_album_id;
						}

					}

					$all_albums = implode(',', $all_list );
					print("<p>Title: $title</p>");
					print("<p>credit: $credit</p>");
					print("<p>Album: $all_albums</p>");
				?>
				</div>
				<hr class="line">
			</div>

			<?php
				if ( isset($_SESSION['logged_user_by_sql'] ) ) {
			 		require_once 'includes/img_admin.php';
			 	}
			?>
			
		</nav>
		<div id="wrapper">
			<div id="arrow">
			<a id="sidebar_show"></a>
			</div>
			<div class="inner">
				
				<div class="thumbnails">
				<?php

					#print( "<p>Showing movies using the SQL query <br>$html_safe_sql</p>");
				
					//Loop through the $result rows fetching each one as an associative array
					while ($row = $img_result->fetch_assoc()) {
						print('<div class="container">');
						$img_id = $row['imageID'];
						
						$href_img = "image.php?image_id=$img_id";
						$href_edit = "edit-image.php?image_id=$img_id";
						#print("<a style='cursor:pointer', href='$href'>");
						print('<div class="img">');
						$imgurl = $row['filepath'];
						print("<img class='img' src = '$imgurl' alt=''>");
						print("</div>");
						print('<div class="imgmask">');
						#print("<a href='$href_img'>View</a>");
						#print("<a href='$href_edit'>Edit</a>");
						print("</div>");
						print("</div>");
					}

				?>
				</div>

			</div>	
		</div>
		
	</main>
	<footer>
	</footer>


</body>
</html>