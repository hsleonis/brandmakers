<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tabular Input test';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->params['adminEmail'];
//echo Yii::$app->params['theme'];
?>

<?php

	Pjax::begin(['id' => 'countries']);
		$form = ActiveForm::begin();
		


		echo TabularForm::widget([
		    'dataProvider'=>$dataProvider,
		    'form'=>$form,
		    'attributes'=>$model->formAttribs,
		    'gridSettings'=>[
		        'floatHeader'=>true,
		        'panel'=>[
		            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
		            'type' => GridView::TYPE_PRIMARY,
		            'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success create_cat_btn']) . ' ' . 
		                    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
		                    Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary'])
		        ]
		    ]   
		]);
		ActiveForm::end();

	Pjax::end();
	
?>

<!-- Modal -->
<div class="modal fade" id="myModal_create_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
                
      			<div class="countries-form">
 
					<?php $form = ActiveForm::begin([
				                'id' => 'cat-form-update',
				                'enableAjaxValidation' => false,
				                'enableClientValidation' =>  true,
				                
				            ]); ?>
				 
					    <?= $form->field($model, 'cat_title')->textInput(['maxlength' => 200]) ?>
					    <?= $form->field($model, 'cat_desc')->textInput(['maxlength' => 200]) ?>
					    <input type="hidden" maxlength="200" name="ProductCategory[cat_create]" class="form-control" value="ok">
					 
					 
					    <div class="form-group">
					        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
					    </div>
					 
					<?php ActiveForm::end(); ?>
				</div>

      </div>

    </div>
  </div>
</div>



<?php

	$this->registerJs("
            $(document).ready(
                    $(document).delegate('#cat-form-update', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            $('#countries').html(dt.post_list);

                                            alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );

			$(document).delegate('.create_cat_btn', 'click', function() {
				$('#myModal_create_cat').modal('show');
				return false;
			});

    ", yii\web\View::POS_END, 'post_submit_update');

	$this->registerJs("
            $(document).ready(
                    $(document).delegate('#w0', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){

                                            alertify.log(dt.files, 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );


    ", yii\web\View::POS_END, 'post_submit_updatesdf');

?>