			<div id="add_album_module" class="admin">
				<a id="addalbum_toggle"><h3>Add album</h3></a>
				<div class = "side_module" id="add_album">
					<form method="POST">
						<input type="text" name="al_title" placeholder="Title" required>
						<input type="text" name="al_tag" placeholder="Tag">
						<input type="submit" name="al_submit" value="Add">
					</form>
				</div>
				<hr class="line">
			</div>


			<div id="delete_album_module" class="admin">
				<a id="deletealbum_toggle"><h3>Delete album</h3></a>
				<div class = "side_module" id="delete_album">
				
				<form method="POST">
					<div class="checkbox">
				Albums: 
				<?php 
					foreach ($albumlist as $type) {
						$title = $type['title'];
						
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

			<div id="add_img_module" class="admin">
				<a id="addimg_toggle"><h3>Add image</h3></a>
				<div id="add_image" class = "side_module">
				<?php  
					require_once 'includes/addimage.php';
				?>
				<form id="add" method="POST"  enctype="multipart/form-data">
					<input type="text" name="title" placeholder="title" required>
					<input type="text" name="credit" placeholder="credit" required>
					<input type="file" name="image" required> 
					<div class="checkbox">
				Albums: 
				<?php 
					foreach ($albumlist as $type) {
						$title = $type['title'];
						
						print("<input type='checkbox' id=\"$title\" name='albumlist[]' value=\"$title\">");
						print("<label for=\"$title\">$title</label>");
						
					}
				 ?>
				 	</div>
					<input type="submit" name="submit" value="Add"/>
					
				</form>
				</div>
			</div>