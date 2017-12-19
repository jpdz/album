<?php
	$sql_all_albums = 'SELECT * FROM Albums';
	$result = $mysqli->query($sql_all_albums);
	//If no result, print the error
	if (!$result) {
		print($mysqli->error);
		exit();
	}

    $albumlist = array();

	//Loop through the $result rows fetching each one as an associative array
	while ($row = $result->fetch_assoc()) {
		$album_ID = $row['albumID'];
		$href = "album.php?album_id=$album_ID";
		print( "<li class='title'><a href= '$href' >{$row[ 'title' ]}</a></li>" );
		$temp = array();
		$temp['albumID'] = $row['albumID']; 
		$temp['title'] = $row['title']; 
		$temp['url'] = $row['url'];
 		$albumlist[] = $temp;
	}
?>