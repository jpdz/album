<?php 

if(isset($_POST["title"])){	
	$img_title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
	$img_credit = filter_input( INPUT_POST, 'credit', FILTER_SANITIZE_STRING );	
	if(!empty($img_title) && !empty($img_credit) && !empty($_FILES['image'])){
		
		$newPhoto = $_FILES['image'];
		$originalName = "img/".$newPhoto['name'];
		
		if($newPhoto['error']==0){
			$tempName = $newPhoto['tmp_name'];
			move_uploaded_file($tempName, $originalName);
		}

		# insert image into Images				

		$insertSql = "INSERT into Images(title, filepath, credit) values('$img_title', '$originalName', '$img_credit')";
		$insert_result =$mysqli->query($insertSql);

		if (!$insert_result) {
			print($mysqli->error);
			exit();
		}		

		if(!empty($_POST['albumlist'])){			

			$findSql = "SELECT max(imageID) from Images";
			$findRes = $mysqli->query($findSql);
			$img_id = 0;
			while ($row = $findRes->fetch_row()){
				$img_id = $row[0];
			}

			foreach ($_POST['albumlist'] as $index => $check) {
				
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

				#insert relationship into enrollment table
				$enrollSql = "INSERT into Enrollment values('$img_id', '$temp_album_id')";
				
				$enrollinsert = $mysqli->query($enrollSql);					
				if (!$enrollinsert) {
					print($mysqli->error);
					exit();
				}	
			}
		}		
	}	
}
?>