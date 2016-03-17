<?php

use yii\helpers\Url;
?>
<?php
	if(!empty($images)){
		foreach ($images as $key) {
?>

	<div class="col-md-3 post_image_<?php echo $key->id; ?>" image_id="<?php echo $key->id; ?>" style="display:inline-block;">
		<div class="image_cont">
			<div class="uploaded_image_wrap">
				<img src="<?php echo Url::base().'/post_uploads/'.$key->image; ?>" alt="<?php echo $key->image; ?>" width="100%">
			</div>
			<label>Short Title</label>
			<input type="text" name="short_title">
			<label>Short Description</label>
			<input type="text" name="short_desc">

			<div class="image_upload_cont_btn_panel">
	            <button name="save" class="btn btn-xs btn-success image_save_btn" data_id="<?php echo $key->id; ?>">Save</button>
	            <button name="save" class="btn btn-xs btn-danger image_delete_btn_post" data_id="<?php echo $key->id; ?>">Delete</button>
	        </div>
		</div>
	</div>

<?php
		}
	}
?>
