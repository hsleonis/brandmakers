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

<div class="pane" style="float:left;">
    <h2><span>Create Product Form</span></h2>

    <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-4">
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
                <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
                
                <?= $form->field($model, 'sort_order')->textInput(['maxlength' => 255]) ?>
            
                <?php
                    $data = array ('1'=>'Yes', 
                                   '0'=>'No', 
                                    )
                ?>

                <label>Is Featured?</label>
                <?= Select2::widget([
                        'model' => $model, 
                        'attribute' => 'is_featured',
                        'data' => $data,
                        'options' => ['placeholder' => 'Select one ...','multiple'=>false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            

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
        
        <div class="col-md-8">
            <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor']) ?>

            <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
        </div>

        

        

        <div class="form-group">
            
        </div>

    <?php ActiveForm::end(); ?>
</div>

<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_product');

?>

