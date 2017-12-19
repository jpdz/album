<?php  
if(isset($_POST["al_title"])){

	$al_title = filter_input( INPUT_POST, 'al_title', FILTER_SANITIZE_STRING );
	$al_tag = filter_input( INPUT_POST, 'al_tag', FILTER_SANITIZE_STRING );
	$al_create_date = date('Y-m-d');
	$al_modify_date = date('Y-m-d');
	$al_img = "img/1.jpg";
				
	if(!empty($al_title)){
		if(empty($al_tag)){
			$insert_al_sql = "INSERT INTO Albums(title, date_created, date_modified, url) values ('$al_title', '$al_create_date', '$al_modify_date', '$al_img')";
		}
		else
		{
			$insert_al_sql = "INSERT INTO Albums(title,date_created, date_modified, tag, url) values ('$al_title', '$al_create_date', '$al_modify_date', '$al_tag', '$al_img')";
		}
	
		$insert_al_result =$mysqli->query($insert_al_sql);
	
		if (!$insert_al_result) {
			print($mysqli->error);
			exit();
		}	
	}
}
?>