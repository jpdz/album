		<div id="edit_image">
			<a id="addimg_toggle"><h3>Edit image</h3></a>

			<div id="add_image" class="side_module">
				<form id="add" method="POST">
				<?php 
					print("<input type='text' name='im_title' value='$title' >");
					print("<input type='text' name='im_credit' value='$credit' >"); 
				?>
					<input type="submit" name="im_submit" value="Save"/>
				</form>
			</div>
			<hr class="line">
			</div>

			<div id="delete_album_module" class="admin">
				<a id="deletealbum_toggle"><h3>Delete image</h3></a>
				<div class = "side_module" id="delete_album">
				<?php 
				 if(isset($_POST['delete_submit'])){

					$delete_album_sql = "DELETE from Images where imageID = $img_id";
					$delete_sql = "DELETE from Enrollment where imageID = $img_id";
					$delete_res = $mysqli->query($delete_album_sql);
					if (!$delete_res) {
						print($mysqli->error);
						exit();
					}
					$delete_res2 = $mysqli->query($delete_sql);
					if (!$delete_res2) {
						print($mysqli->error);
						exit();
					}

				}

				?>
				<form method="POST">
				 	<a id="sure_show" class="submit">Delete</a>
				 	<div id="sure">
				 	<p>Are you sure?</p>
					<input type="submit" name="delete_submit" value="Yes"/>
					<a id="sure_hide" class="submit">No</a>
					</div>
				</form>
				</div>
				
			</div>