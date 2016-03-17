<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use backend\models\PostImageRel;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#post_tab" aria-controls="home" role="tab" data-toggle="tab">Create post</a></li>
    <li role="presentation"><a href="#image_tab" aria-controls="profile" role="tab" data-toggle="tab">Post Image</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="post_tab">
        <div class="post-form">
            <?php $form = ActiveForm::begin([
                'id' => 'post-form-update',
                'action' => ['productpost/update'],
                'enableAjaxValidation' => false,
                'enableClientValidation' =>  true,
                
            ]); ?>
            <input type="hidden" id="upd_post_id" name="ProductPost[id]" value="">
            <input type="hidden" name="ProductPost[product_id]" value="<?php if(isset($product_id)){echo $product_id;} ?>">
            <?= $form->field($model, 'post_title')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'post_desc')->textArea(['rows' => '6','id'=>'editor3']) ?>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary c_p']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="image_tab">
        <div id="image_tab_cont"></div>

        <div class="uploaded_post_image_cont_wrap">
            <h3>Uploaded Images</h3>
            <div class="uploaded_post_image_cont">
                
            </div>
        </div>
    </div>
  </div>

</div>



<?php

    

    


?>
