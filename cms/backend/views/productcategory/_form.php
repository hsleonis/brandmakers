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
    <div class="box dark full-screen-box">
        <header>
            <div class="icons">
                <i class="fa fa-edit"></i>
            </div>
            <h5>Product Category Form</h5>

            <!-- .toolbar -->
            <div class="toolbar">
                <nav style="padding: 8px;">
                    <a class="btn btn-default btn-xs collapse-box" href="javascript:;">
                        <i class="fa fa-minus"></i>
                    </a> 
                    <a class="btn btn-default btn-xs full-box" href="javascript:;">
                         <i class="fa fa-expand"></i>
                    </a> 
                    <a class="btn btn-danger btn-xs close-box" href="javascript:;">
                        <i class="fa fa-times"></i>
                    </a> 
                </nav>
            </div><!-- /.toolbar -->
        </header>
        <div class="body collapse in" id="div-1" aria-expanded="true" style="">
            <?php $form = ActiveForm::begin(); ?>
              <div class="form-group">
                <label class="control-label col-lg-4" for="text1">Parent Category</label>
                <div class="col-lg-8" style="margin-bottom: 15px;">
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
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <?= Html::activeLabel($model, 'cat_title', ['class'=>'control-label col-lg-4']); ?>
                <div class="col-lg-8">
                    <?= $form->field($model, 'cat_title')->textInput(['maxlength' => 255])->label(false) ?>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <?= Html::activeLabel($model, 'cat_desc', ['class'=>'control-label col-lg-4']); ?>
                <div class="col-lg-8">
                    <?= $form->field($model, 'cat_desc')->textarea(['rows' => 6])->label(false) ?>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-label col-lg-4"></label>
                <div class="col-lg-8">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
              </div><!-- /.form-group -->
              
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


