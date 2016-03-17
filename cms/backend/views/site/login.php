<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> -->
<div class="form-signin">
      <div class="text-center">
        <h3>DC CMS</h3>
      </div>
      <hr>
      <div class="tab-content">
        <div class="tab-pane active" id="login">
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <p class="text-muted text-center">
              Enter your username and password
            </p>
                <?= $form->field($model, 'username', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Ussername'),
                            ],
                        ])->textInput(['class'=>'form-control top'])->label(false) ?>

                <?= $form->field($model, 'password', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Password'),
                            ],
                        ])->passwordInput(['class'=>'form-control bottom'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
          <?php ActiveForm::end(); ?>
        </div>
        <div class="tab-pane" id="signup">
          <form action="index.html">
            <input type="text" class="form-control top" placeholder="username">
            <input type="email" class="form-control middle" placeholder="mail@domain.com">
            <input type="password" class="form-control middle" placeholder="password">
            <input type="password" class="form-control bottom" placeholder="re-password">
            <button type="submit" class="btn btn-lg btn-success btn-block">Register</button>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a data-toggle="tab" href="#login" class="text-muted">Login</a>  </li>
          <li> <a data-toggle="tab" href="#forgot" class="text-muted">Forgot Password</a>  </li>
          <li> <a data-toggle="tab" href="#signup" class="text-muted">Signup</a>  </li>
        </ul>
      </div>
    </div>  