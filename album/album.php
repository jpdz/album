<?php session_start(); 
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

		#$album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT );
		#$album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_STRING );
		$album_id = $_GET['album_id'];


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
		
		$sql_this_ablum = "select * from Albums
		where albumID = $album_id";

		$ablum = $mysqli->query($sql_this_ablum);
		
		//If no result, print the error
		if (!$ablum) {
			print($mysqli->error);
			exit();
		}

		$this_album = array();

		while ($row = $ablum->fetch_assoc()) {
			$this_album['title'] = $row['title'];
			$this_album['date_create'] = $row['date_created'];
			$this_album['date_modify'] = $row['date_modified'];
			$this_album['tag'] = $row['tag'];
		}

		
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
				<div id="search" class="side_module">
				<form action="search1.php" method="POST">
					<input type="text" name="search_title" placeholder="title">
					<input type="text" name="search_credit" placeholder="credit">
					<?php  
					$title = $this_album['title'];
					print("<input type='text' name='search_album' value='$title' style='display: none;' >");
					?>
					<input type="submit" name="search_submit" value="search">

				</form>
				</div>
				<hr class="line">
			</div>
			
			<div id="show_album_module">
				<a id="allalbum_toggle"><h3>All albums</h3></a>
				<div id="catalog" class="side_module">
				<ul>
				<?php 
					require_once 'includes/showalbum.php';
				?>
				</ul>
				</div>
				<hr class="line">
			</div>

			<?php
			if ( isset($_SESSION['logged_user_by_sql'] ) ) {
				require_once 'includes/album_admin.php';  }
			?>


			
			
		</nav>
		<div id="wrapper">
			<div id="arrow">
			<a id="sidebar_show"></a>
			</div>
			<div class="inner">
				<div class="center">
				<?php 

						$sql = "SELECT * FROM Images inner join 
							(select imageID from Enrollment
							where albumID =  $album_id ) As selected 
							on selected.imageID = Images.imageID"; 	
							$result_images = $mysqli->query($sql);
							if (!$result_images) {
							print($mysqli->error);
							exit();
							}


					
						print("<h1>{$this_album['title']}</h1>");
						print("<p>Created at {$this_album['date_create']}</p>");
						print("<p>Last Modify: {$this_album['date_modify']}</p>");
						if(!empty($this_album['tag'])){
							print("<p>Tag: {$this_album['tag']}</p>");
						}
					

				?>
				</div>
				<div class="thumbnails">
				<div class="thumbnails_2">
				<?php

					

					#print( "<p>Showing movies using the SQL query <br>$html_safe_sql</p>");
				
					//Loop through the $result rows fetching each one as an associative array
					while ($row = $result_images->fetch_assoc()) {
						$img_id = $row['imageID'];
						$href = "image.php?img_id=$img_id";
						$href2 = "imagedelete.php?img_id=$img_id";
						print("<div class='small'>");
							print("<div class='smaller'>");
							$imgurl = $row['filepath'];
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


								print( "<p class='name'><a style='cursor:pointer' href='$href'>{$row[ 'title' ]}</a></p>" );
							print("</div>");
						print("</div>");
					}
					


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