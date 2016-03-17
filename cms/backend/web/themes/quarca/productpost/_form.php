<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-post-form">
    <div class="pane">
        <?php $form = ActiveForm::begin([
            'id' => 'post-form',
            'action' => ['productpost/create'],
            'enableAjaxValidation' => false,
            'enableClientValidation' =>  true,
            
        ]); ?>
        <input type="hidden" name="ProductPost[product_id]" value="<?php if(isset($product_id)){echo $product_id;} ?>">

        <?= $form->field($model, 'post_title')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'post_desc')->textarea(['rows' => 6,'id'=>'editor1']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
