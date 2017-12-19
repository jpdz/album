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
						$temp = array();
						$temp['albumID'] = $row['albumID']; 
						$temp['title'] = $row['title']; 
						$temp['url'] = $row['url'];
				 		$albumlist[] = $temp;
					}

					if(isset($_POST['delete_submit'])){
						if(!empty($_POST['dealbumlist'])){			

							foreach ($_POST['dealbumlist'] as $index => $check) {
								
								#find album id based on album name
								$album_sql = "SELECT albumID from Albums where title = '$check'";
								$album_res = $mysqli->query($album_sql);
								
								if(!$album_res){
									print($mysqli->error);
									exit();
								}
								
								$temp_album_id = 0;
								while ($row = $album_res->fetch_row()){
									$temp_album_id = $row[0];
								}

								#delete album from the list
								$delete_album_sql = "DELETE from Albums where albumID = $temp_album_id";
		
								$delete_res = $mysqli->query($delete_album_sql);
								if (!$delete_res) {
									print($mysqli->error);
									exit();
								}

								
							}
						}		
					}

				?>