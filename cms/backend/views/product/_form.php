<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\ProductCategory;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


        <div class="box dark full-screen-box">
            <header>
                <div class="icons">
                  <i class="fa fa-edit"></i>
                </div>
                <h5>Create Product Form</h5>

                <!-- .toolbar -->
                <div class="toolbar">
                  <nav style="padding: 8px;">
                    <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
                      <i class="fa fa-minus"></i>
                    </a> 
                    <a href="javascript:;" class="btn btn-default btn-xs full-box">
                      <i class="fa fa-expand fa-compress"></i>
                    </a> 
                    <a href="javascript:;" class="btn btn-danger btn-xs close-box">
                      <i class="fa fa-times"></i>
                    </a> 
                  </nav>
                </div><!-- /.toolbar -->
            </header>
            <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                <?php $form = ActiveForm::begin(); ?>

                <div class="col-md-4">
                    <div class="row">
                        <?= Html::activeLabel($ProductCategoryRel,'category_id'); ?>
                        <?= 
                            Select2::widget([
                                'model' => $ProductCategoryRel, 
                                'attribute' => 'category_id',
                                'data' => ProductCategory::getHierarchy_cat(),
                                'options' => ['placeholder' => 'Select Category ...','multiple'=>true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'model')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'size')->textInput(['maxlength' => 255]) ?>

                        <?php
                            $data = array ('1'=>'Active', 
                                           '0'=>'Inactive', 
                                            )
                        ?>

                        <label>Status</label>
                        <?= Select2::widget([
                                'model' => $model, 
                                'attribute' => 'status',
                                'data' => $data,
                                'options' => ['placeholder' => 'Select Status ...','multiple'=>false],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor']) ?>

                    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
                </div>

                

                

                <div class="form-group">
                    
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor", {
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_product');

?>

