<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">
    <div class="row">
        <div class="pane">
            <div class="user-form">

                <h2><span><?= $model->isNewRecord?'Create':'Update';  ?> User Form</span></h2>
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
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>

<div class="col-md-6">
    <div class="pane">
        <?php if(!$model->isNewRecord){ ?>
                    
                <div class="product_image"><img id="blah" src="<?= Url::base().'/user_img/'.$model->image; ?>" alt="" /></div>
                    
        <?php }else{
                echo '<div class="product_image"><img id="blah" src="#" alt="" /></div>';
            }  
        ?>
    </div>
</div>


<?php
    $this->registerJs("
                    $('#user-image').on('change', function() { 
                        readURL(this);
                    });

                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                $('#blah').attr('src', e.target.result);
                                $('#blah').attr('width','300');
                            }

                            reader.readAsDataURL(input.files[0]);
                        }
                    }
    ", yii\web\View::POS_READY, 'user-image');
?>
