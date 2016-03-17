<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">
    <div class="row">
        <div class="box dark full-screen-box">
            <header>
                <div class="icons">
                  <i class="fa fa-edit"></i>
                </div>
                <h5><?= $model->isNewRecord?'Create':'Update';  ?> User Form</h5>

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

                <div class="user-form">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                    <?= $model->isNewRecord?$form->field($model, 'username')->textInput(['maxlength' => 255]):'' ?>

                    <?= $model->isNewRecord?$form->field($model, 'password')->passwordInput(['maxlength' => 255]):''; ?>

                    <?= $form->field($model, 'image')->fileInput() ?>

                    <?php
                        $data = array ('1'=>'Active', 
                                       '0'=>'Inactive'
                                        );
                        echo $form->field($model, 'status')
                                ->dropDownList(
                                    $data,           // Flat array ('id'=>'label')
                                    ['prompt'=>'Select Status']    // options
                                );
                        

                    ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                
            </div>
        </div>
    </div>
</div>



