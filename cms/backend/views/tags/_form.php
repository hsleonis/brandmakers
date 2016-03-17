<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-md-4">
    <div class="row">
        <div class="box dark full-screen-box">
            <header>
                <div class="icons">
                  <i class="fa fa-edit"></i>
                </div>
                <h5><?= $model->isNewRecord?'Create':'Update';  ?> Tags Form</h5>

                <!-- .toolbar -->
                <div class="toolbar">
                  <nav style="padding: 8px;">
                    <a class="btn btn-default btn-xs collapse-box" href="javascript:;">
                      <i class="fa fa-minus"></i>
                    </a> 
                    <a class="btn btn-default btn-xs full-box" href="javascript:;">
                      <i class="fa fa-expand fa-compress"></i>
                    </a> 
                    <a class="btn btn-danger btn-xs close-box" href="javascript:;">
                      <i class="fa fa-times"></i>
                    </a> 
                  </nav>
                </div><!-- /.toolbar -->
            </header>
            <div class="body full-screen-box collapse in" id="div-1" aria-expanded="true" style="">

                <div class="tags-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                
            </div>
        </div>
    </div>
</div>



