<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper">
      
      <div class="member-container">
          
      <div class="member-container-inside">
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'username', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Ussername'),
                            ],
                        ])->textInput(['class'=>'form-control top'])->label(false) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'password', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Password'),
                            ],
                        ])->passwordInput(['class'=>'form-control bottom'])->label(false) ?>
            </div>
            <div class="form-group">
              <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
            </div>
          <?php ActiveForm::end(); ?>
      </div><!-- member-container-inside -->
      
      <p><small><?= Yii::$app->params['copyright_text']; ?></small></p>
      </div><!-- member-container -->
      
  </div><!-- wrapper -->

<style type="text/css">
  .required::after{
    content: '';
  }
  .checkbox label{
    margin-left: 6px;
  }
</style>