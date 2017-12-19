			<div id="add_img_module" class="admin">
				<a id="addimg_toggle"><h3>Add image</h3></a>

				<div id="add_image" class="side_module">

				<?php 



					if(isset($_POST['delete_submit'])){
						if(!empty($_POST['dealbumlist'])){			

							foreach ($_POST['dealbumlist'] as $index => $check) {
								
								#find album id based on album name
								
								$img_sql = "SELECT imageID from Images where title = '$check'";
								$img_res = $mysqli->query($img_sql);

								if(!$img_res){
									print($mysqli->error);
									exit();
								}
								
								$temp_img_id = 0;
								while ($row = $img_res->fetch_row()){
									$temp_img_id = $row[0];
								}

								#delete album from the list
								$delete_img_sql = "DELETE from Enrollment where albumID = $album_id and imageID = $temp_img_id";
		
								$delete_res = $mysqli->query($delete_img_sql);
								if (!$delete_res) {
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
						}		
					}

					require_once 'includes/simpleaddimage.php';

				?>
				<form id="add" method="POST" enctype="multipart/form-data">
					<select name="imagetitle">
					<?php 
						while ($row = $select_result->fetch_assoc()){
							$img_title = $row['title'];
							print("<option value='$img_title'>$img_title</option>");
						} 	
					?>
  					</select>
					<input type="submit" name="submit" value="Add"/>
				</form>
				</div>
				<hr class="line">
			</div>

			<div id="delete_album_module" class="admin">
				<a id="deletealbum_toggle"><h3>Delete images</h3></a>
				<div class = "side_module" id="delete_album">
				<?php 
				 	
				 	$sql_delete_img = "SELECT * from Images
				 	where imageID in (select imageID from Enrollment 
				 	where albumID = $album_id)"; 

				 	$delete_img_res = $mysqli->query($sql_delete_img);
				 	$all_img = $mysqli->query($sql_delete_img);

				 	if(!$delete_img_res){
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


				 	

				?>
				<form method="POST">
					<div class="checkbox">
				Images: 
				<?php 
					while($row = $delete_img_res->fetch_assoc()) {
						$title = $row['title'];
						
						print("<input type='checkbox' id=\"$title\" name='dealbumlist[]' value=\"$title\">");
						print("<label for=\"$title\">$title</label>");
						
					}
				 ?>
				 	</div>
				 	<a id="sure_show" class="submit">Delete</a>
				 	<div id="sure">
				 	<p>Are you sure?</p>
					<input type="submit" name="delete_submit" value="Yes"/>
					<a id="sure_hide" class="submit">No</a>
					</div>
				</form>
				</div>
				<hr class="line">
			</div>

			<div id="add_album_module" class="admin">
				<a id="addalbum_toggle"><h3>Edit album</h3></a>
				<div class = "side_module" id="add_album">
				<?php 
				 	require_once 'includes/editalbum.php';
				 	$title = $this_album['title'];
				 	$tag = $this_album['tag'];
				?>
					<form method="POST">
						<?php 
						print("<input type='text' name='al_title' value='$title' >");
						print("<input type='text' name='al_tag' value='$tag' placeholder='tag' >");
						print("Cover: <select name='imagetitle2'>");
						
						print("<option value='' selected></option>");
						while ($row = $all_img->fetch_assoc()){
							$img_title = $row['title'];
							print("<option value='$img_title'>$img_title</option>");
						} 	
						?>
  						</select>
						<input type="submit" name="al_submit" value="Save">
					</form>
				</div>
				<hr class="line">
			</div>