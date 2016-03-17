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
                'action' => ['post/update'],
                'enableAjaxValidation' => false,
                'enableClientValidation' =>  true,
                
            ]); ?>
            <input type="hidden" id="upd_post_id" name="Post[id]" value="<?php if(isset($page_id)){echo $page_id;} ?>">
            <input type="hidden" name="Post[page_id]" value="<?php if(isset($page_id)){echo $page_id;} ?>">
            <?= $form->field($model, 'post_title')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor3']) ?>

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

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#post-form-update', 'beforeSubmit', function(event, jqXHR, settings) {
                        
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

                                            alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'post_submit_update');

    


?>
