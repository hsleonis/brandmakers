<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="pane" style="float:left; width:100%;">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
        

        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'ext_url')->textInput() ?>

        <?= $form->field($model, 'status')
                                ->dropDownList(
                                    array ('1'=>'Active', '0'=>'Inactive') 
                                ); ?>


    </div>

    <div class="col-md-8">

        <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>


<?php

    $this->registerJs("
                        $('#news-title').on('change', function() { 
                            var text = $(this).val();
                            var slug = convertToSlug(text);

                            $('#news-slug').val(slug);
                        });

                        function convertToSlug(Text)
                            {
                                return Text
                                    .toLowerCase()
                                    .replace(/[^\w ]+/g,'')
                                    .replace(/ +/g,'-')
                                    ;
                            }
    ", yii\web\View::POS_END, 'create_post');

?>
