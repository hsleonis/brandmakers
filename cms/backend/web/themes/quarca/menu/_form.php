<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-md-5 row">
  
  <div class="pane">
      <h2><span><?= $model->isNewRecord?'Create':'Update';  ?> Menu Form</span></h2>
      
      <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
          </div>

      <?php ActiveForm::end(); ?>
  </div>


</div>


