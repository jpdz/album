<?php  
if(isset($_POST["im_submit"])){
	
	$array_edit = array();

	$im_title = filter_input( INPUT_POST, 'im_title', FILTER_SANITIZE_STRING );
	$im_credit = filter_input( INPUT_POST, 'im_credit', FILTER_SANITIZE_STRING );
	
	if(!empty($im_title)){
		$array_edit[] = "title = '$im_title'";
	}
	if(!empty($im_credit)){
		$array_edit[] = "credit = '$im_credit'";
	}

	if(!empty($array_edit)){

	$edit_query = "UPDATE Images set ";
	
	$edit_query .= implode(',', $array_edit);
	
	$edit_query .= " where imageID = '$img_id'";
	
	$edit_res = $mysqli->query($edit_query);

	if(!$edit_res){
		print($mysqli->error);
		exit();
	}
	}
	

}
?>