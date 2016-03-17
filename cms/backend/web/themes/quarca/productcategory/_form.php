<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-6 product-category_form">
    <div class="pane">
        <h2><span>Product Category Form</span></h2>

        <?php $form = ActiveForm::begin(); ?>
              <div class="form-group">
                <label>Parent Category</label>
                
                    <?= 
                       
                        Select2::widget([
                            'model' => $ProductCategorySelfRel, 
                            'attribute' => 'parent_cat_id',
                            'data' => ProductCategory::getHierarchy_cat(),
                            'options' => ['placeholder' => 'Select parent category ...','multiple'=>true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
              </div><!-- /.form-group -->

              <div class="form-group">
                    <?= Html::activeLabel($model, 'cat_title'); ?>
                    <?= $form->field($model, 'cat_title')->textInput(['maxlength' => 255])->label(false) ?>
              </div><!-- /.form-group -->

              <div class="form-group">
                    <?= Html::activeLabel($model, 'cat_slug'); ?>
                    <?= $form->field($model, 'cat_slug')->textInput(['maxlength' => 255])->label(false) ?>
              </div><!-- /.form-group -->

              <div class="form-group">
                    <?= Html::activeLabel($model, 'cat_desc'); ?>
                    <?= $form->field($model, 'cat_desc')->textarea(['rows' => 6])->label(false) ?>
              </div><!-- /.form-group -->

              <div class="form-group">
                    <?= Html::activeLabel($model, 'sort_order'); ?>
                    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => 255])->label(false) ?>
              </div><!-- /.form-group -->

              <div class="form-group text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
              </div><!-- /.form-group -->
              
        <?php ActiveForm::end(); ?>


    </div>
</div>


