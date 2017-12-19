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
		require_once "includes/settings.php";
		
		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		//Was there an error connecting to the database?
		require_once 'includes/addalbum.php';
		require_once 'includes/deletealbum.php';


		
	?>
<body>
	<?php
		
		$search_query= "SELECT * from Images";
		$search_condition = array();
		$searches = array();

		if(isset($_POST["search_album"])){
					
			$search_album = filter_input( INPUT_POST, 'search_album', FILTER_SANITIZE_STRING);
			
			if(!empty($search_album)){
				$searches[] ='album = '.$search_album; 
				$search_query = "SELECT * from Images inner join Enrollment on Images.imageID = Enrollment.imageID";
				$album_sql = "SELECT albumID from Albums where title like '$search_album'";
				$album_res = $mysqli->query($album_sql);

				if(!$album_res){
					print($mysqli->error);
					exit();
				}

				$temp_album_id = 0;
					while ($row = $album_res->fetch_row()){
						$temp_album_id = $row[0];
					}

				$search_condition[] = "albumID = '$temp_album_id'";
			}
			
					
		}
				
		

		if(isset($_POST["search_title"])){
				
			$search_title = filter_input( INPUT_POST, 'search_title', FILTER_SANITIZE_STRING );
			if(!empty($search_title)){
				$searches[] = 'title like '.$search_title;
				$search_condition[] = "title regexp '$search_title'";
			}
					
		}


		if(isset($_POST["search_credit"])){
				
			$search_credit = filter_input( INPUT_POST, 'search_credit', FILTER_SANITIZE_STRING);
			if(!empty($search_credit)){
				$searches[] ='credit like '.$search_credit;
				$search_condition[] = "credit like '$search_credit'";
			}
				

		}


		if( !empty( $search_condition ) ) {
			//Build the WHERE clause
			$search_query .= ' WHERE ';
			//Add the searches by joining any elements together with AND
			$search_query .= implode(' AND ', $search_condition );
		}

		
		$search_result = $mysqli->query($search_query);
		if (!$search_result) {
			print($mysqli->error);
			exit();
		}
		

	?>

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

			<?php
			if ( isset($_SESSION['logged_user_by_sql'] ) ) {
			 	require_once "includes/albumlist_admin.php";
			 }
			?>

		</nav>
		<div id="wrapper">
			<div id="arrow">
			<a id="sidebar_show"></a>
			</div>
			<div class="inner">
				<div class="center">
				<?php 
				
				
					$sub_title = "Search result for ";
					$sub_title.= implode(' AND ', $searches );
					print("<h2>$sub_title</h2>");
					

				?>
				</div>
				<div class="thumbnails">
				<div class="thumbnails_2">
				<?php

					#print( "<p>Showing movies using the SQL query <br>$html_safe_sql</p>");
						
					//Loop through the $result rows fetching each one as an associative array
					//$search_query = "SELECT * from Images";
					//$search_result = $mysqli->query($search_query);
					while ($row = $search_result->fetch_assoc()) {
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