<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="post-form">
    <?php $form = ActiveForm::begin([
        'id' => 'post-form',
        'action' => ['post/create'],
        'enableAjaxValidation' => false,
        'enableClientValidation' =>  true,
        
    ]); ?>

    
    <input type="hidden" name="Post[page_id]" value="<?php if(isset($page_id)){echo $page_id;} ?>">
    <?= $form->field($model, 'post_title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor1']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success c_p' : 'btn btn-primary c_p']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#post-form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            $('.list_of_post').html(dt.post_list);
                                            $('.post_sort').sortable();
                                            
                                            $('#post-form')[0].reset();
                                            CKEDITOR.instances.editor1.setData('');
                                            alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'post_submit');

    



?>
