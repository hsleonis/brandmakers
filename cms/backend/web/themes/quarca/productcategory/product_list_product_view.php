<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>


<?php
	
	foreach ($data as $key) {
		$value = $key->products;
?>

	
	<li class="col-md-4 product" data-id="<?php echo $value->id; ?>" role="option" aria-grabbed="false" draggable="true">
		<div class="pane" style="padding:10px;">
			<div class="image_cont">
				<div class="uploaded_image_wrap product_view_image<?php echo $value->id; ?>">
					<?php if(!empty($value->product_image)){ ?>
						<img src="<?php echo Url::base().'/product_uploads/' .$value->product_image[0]->image; ?>" alt="<?php echo $value->product_image[0]->image; ?>" width="100%">
					<?php } ?>
				</div>
				<label class="product_view_label<?php echo $value->id; ?>"><?php echo $value->title; ?></label>
				<div class="image_upload_cont_btn_panel">
		            <button name="save" class="btn btn-xs btn-success update_btn_product" data_id="<?php echo $value->id; ?>">Update</button>
		            <button name="view" class="btn btn-xs btn-primary view_btn_product" data_id="<?php echo $value->id; ?>">View</button>
		        </div>
			</div>
		</div>
	</li>

<?php

	}

?>


