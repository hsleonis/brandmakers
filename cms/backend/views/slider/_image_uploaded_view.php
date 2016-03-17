<?php 

?>
<li class="col-md-4 image_<?php echo $id; ?>" image_id="<?php echo $id; ?>">
	<div class="loader_img"></div>
	<div class="image_cont">
		<div class="uploaded_image_wrap">
			<img src="<?php echo $url; ?>" alt="<?php echo $basename; ?>" width="100%">
		</div>
		<label>Short Title</label>
		<input type="text" name="short_title" class="image_info_title<?php echo $id; ?>">
		<label>Short Description</label>
		<input type="text" name="short_desc" class="image_info_desc<?php echo $id; ?>">


		<div class="image_upload_cont_btn_panel">
            <button name="save" class="btn btn-xs btn-primary slider_image_info_save_btn" data_id="<?php echo $id; ?>">Save</button>
            <button name="save" class="btn btn-xs btn-default image_delete_btn" data_id="<?php echo $id; ?>">Delete</button>
        </div>
	</div>
</li>