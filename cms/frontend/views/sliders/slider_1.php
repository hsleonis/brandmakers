<?php
	use frontend\models\Slider;
	use yii\helpers\Url;

	$this->registerJsFile(Url::base()."/js/jquery.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base()."/js/camera.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base()."/js/jquery.mobile.customized.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base()."/js/jquery.easing.1.3.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

	$this->registerJs("
                    jQuery(function(){
						
						jQuery('#camera_wrap_1').camera({
							thumbnails: true
						});
					});
    ", yii\web\View::POS_END, 'slider_activate');

	$this->registerCssFile(Url::base()."/css/camera.css");
?>


   
	<div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
        <?php 

			$data = Slider::get_slider_1(1); 
			foreach ($data->slider_rel as $key => $value) {
		?>

			<div data-thumb="<?php echo \Yii::$app->urlManagerBackEnd->baseUrl.'/slider_images/thumb/'.$value->image; ?>" 
				 data-src="<?php echo \Yii::$app->urlManagerBackEnd->baseUrl.'/slider_images/'.$value->image; ?>">
	            <div class="camera_caption fadeFromBottom">
	                <?= $value->short_title.'<br/>'.$value->short_desc; ?>
	            </div>
	        </div>

		<?php
			}

		?>
    </div><!-- #camera_wrap_1 -->
