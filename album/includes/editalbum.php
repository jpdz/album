<?php  
if(isset($_POST["al_submit"])){
	
	$array_edit = array();

	$al_title = filter_input( INPUT_POST, 'al_title', FILTER_SANITIZE_STRING );
	$al_tag = filter_input( INPUT_POST, 'al_tag', FILTER_SANITIZE_STRING );
	$al_modify_date = date('Y-m-d');	

	

	if(!empty($_POST["imagetitle2"])){
		$img_title =$_POST["imagetitle2"];
		$findSql = "SELECT filepath from Images where title = '$img_title'";
		$findRes = $mysqli->query($findSql);
		while ($row = $findRes->fetch_row()){
			$al_img = $row[0];
			if(!empty($al_img)){
				$array_edit[] = "url = '$al_img'";
			}
		}
	}


	

	
	
	if(!empty($al_title)){
		$array_edit[] = "title = '$al_title'";
	}
	if(!empty($al_tag)){
		$array_edit[] = "tag = '$al_tag'";
	}
	
	$array_edit[] = "date_modified = '$al_modify_date'";

	$edit_query = "UPDATE Albums set ";
	
	$edit_query .= implode(',', $array_edit);
	
	$edit_query .= " where albumID = '$album_id'";
	
	$edit_res = $mysqli->query($edit_query);

	if(!$edit_res){
		print($mysqli->error);
		exit();
	}
	
	

}
?>