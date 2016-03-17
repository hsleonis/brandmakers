<?php 

use kartik\checkbox\CheckboxX;
?>
<li class="col-md-3 image_<?php echo $id; ?>" image_id="<?php echo $id; ?>">
	<div class="loader_img"></div>
	<div class="image_cont">
		<div class="uploaded_image_wrap">
			<img src="<?php echo $url; ?>" alt="<?php echo $basename; ?>" width="100%">
		</div>
		<label>Short Title</label>
		<input type="text" name="short_title" class="page_image_info_title<?php echo $id; ?>">
		<label>Short Description</label>
		<input type="text" name="short_desc" class="page_image_info_desc<?php echo $id; ?>">

		<div class="col-md-12"><div class="row" style="margin-top:5px;">
            <label for="s_1">Is Gallery Photo?</label>
            <?= CheckboxX::widget([
                'name'=>'s_1'.$id,
                'value'=>$model->is_gallery,
                'options'=>['id'=>'isgallery_'.$id],
                'pluginOptions'=>['threeState'=>false,'size'=>'sm']
            ]);?>
        </div></div>


        <div class="col-md-12"><div class="row" style="margin-top:5px;">
            <label for="s_1">Is Banner Photo?</label>
            <?= CheckboxX::widget([
                'name'=>'s_2'.$id,
                'value'=>$model->is_banner,
                'options'=>['id'=>'isbanner_'.$id],
                'pluginOptions'=>['threeState'=>false,'size'=>'sm']
            ]);?>
        </div></div>

		<div class="image_upload_cont_btn_panel">
            <button name="save" class="btn btn-xs btn-primary page_image_info_save_btn" data_id="<?php echo $id; ?>">Save</button>
            <button name="save" class="btn btn-xs btn-default image_delete_btn" data_id="<?php echo $id; ?>">Delete</button>
        </div>
	</div>
</li>