

	<li class="col-md-4 product" data-id="<?php echo $model->id; ?>" role="option" aria-grabbed="false" draggable="true">
		<div class="pane" style="padding:10px;">
			<div class="image_cont">
				<div class="uploaded_image_wrap product_view_image<?php echo $model->id; ?>">
					<img src="<?php echo $url; ?>" alt="<?php echo $basename; ?>" width="100%">
				</div>
				<label class="product_view_label<?php echo $model->id; ?>"><?php echo $model->title; ?></label>

				<div class="image_upload_cont_btn_panel">
		            <button name="save" class="btn btn-xs btn-success update_btn_product" data_id="<?php echo $model->id; ?>">Update</button>
		            <button name="view" class="btn btn-xs btn-primary view_btn_product" data_id="<?php echo $model->id; ?>">View</button>
		        </div>
			</div>
		</div>
	</li>