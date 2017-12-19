<?php  
	if(!empty($_POST["imagetitle"])){
		$img_title =$_POST["imagetitle"];
		$findSql = "SELECT imageID from Images where title = '$img_title'";
		$findRes = $mysqli->query($findSql);
		while ($row = $findRes->fetch_row()){
			$img_id = $row[0];
		} 		
		$enrollSql = "INSERT into Enrollment values('$img_id', '$album_id')";
		
		$enrollinsert = $mysqli->query($enrollSql);
		if (!$enrollinsert) {
			print($mysqli->error);
			exit();
		}

		$al_modify_date = date('Y-m-d');

		$edit_query = "UPDATE Albums set date_modified = '$al_modify_date' where albumID = $album_id";

		$res_edit = $mysqli->query($edit_query);

		if (!$res_edit) {
			print($mysqli->error);
			exit();
		}

		
	}

	$img_not_sql = "SELECT * FROM Images 
	where imageID not in (SELECT imageID from Enrollment where albumID = '$album_id')";

	$select_result =$mysqli->query($img_not_sql);
	if (!$select_result) {
		print($mysqli->error);
		exit();
	}

$sql = "SELECT * FROM Images inner join 
	(select imageID from Enrollment
	where albumID =  $album_id ) As selected 
	on selected.imageID = Images.imageID"; 	
	$result_images = $mysqli->query($sql);
	if (!$result_images) {
	print($mysqli->error);
	exit();
	}
?>