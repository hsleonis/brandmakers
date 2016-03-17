<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */


$this->registerJsFile(Url::base()."/files/html.sortable.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

?>



<div class="col-md-4">
    <div class="row">
        <div class="box dark full-screen-box">
            <header>
                <div class="icons">
                  <i class="fa fa-edit"></i>
                </div>
                <h5><?= $model->isNewRecord?'Create':'Update';  ?> Slider Form</h5>

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

                <div class="slider-form">

                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" name="id" value="<?= $model->id; ?>" class="slider_id_hidden">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <?= FileInput::widget([
        'model' => $SliderImage_model,
        'attribute' => 'image',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/slider/upload_image']),
            'uploadExtraData' => [
                'id' => $model->id
            ],
            'maxFileCount' => 10,
        ],
        'pluginEvents' => [
                'fileuploaded'=>'function(event, data, previewId, index){
                    $(".uploaded_images").append(data.response.view);
                    //$(".sortable").sortable();
                }',
                'filebatchuploadcomplete' => 'function(event, files, extra){
                    $(".fileinput-remove-button").click();
                    //$(".sortable").sortable();
                }',
                
            ]
        ]);
    ?>

    <div class="row">
        <ul class="uploaded_images uploaded_images_slider sortable grid" style="margin-top:15px;">

            <?php
                foreach ($images as $key) {
            ?>

                <li class="col-md-4 image_<?php echo $key->id; ?>" image_id="<?php echo $key->id; ?>">
                    <div class="loader_img"></div>
                    <div class="image_cont">
                        <div class="uploaded_image_wrap">
                            <img src="<?php echo Url::base().'/slider_images/' .$key->image; ?>" alt="<?php echo $key->image; ?>" width="100%">
                        </div>
                        <label>Short Title</label>
                        <input type="text" name="short_title" value="<?= $key->short_title; ?>" class="image_info_title<?php echo $key->id; ?>">
                        <label>Short Description</label>
                        <input type="text" name="short_desc" value="<?= $key->short_desc; ?>" class="image_info_desc<?php echo $key->id; ?>">


                        <div class="image_upload_cont_btn_panel">
                            <button name="save" class="btn btn-xs btn-primary slider_image_info_save_btn" data_id="<?php echo $key->id; ?>">Save</button>
                            <button name="save" class="btn btn-xs btn-default image_delete_btn" data_id="<?php echo $key->id; ?>">Delete</button>
                        </div>
                    </div>
                </li>

            <?php
                }
            ?>
        </ul>
    </div>


    <div class="col-md-12">
        <div class="row save_page_image_sort_order_wrap">
            <input type="button" class="btn btn-sm btn-primary pull-right save_page_image_sort_order" value="Save Sort Order">
        </div>
    </div>



</div>



<?php
    $this->registerJs("
                    $('.sortable').sortable();
                    $(document).delegate('.save_page_image_sort_order', 'click', function() { 
                        var data = [];
                        $('.uploaded_images li').each(function( key, value ) {
                            data.push($(this).attr('image_id'));
                        });
                        
                        var slider = $('.slider_id_hidden').val();

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('slider/save_image_sort_order')."',
                            data: {data:data,slider:slider},
                            beforeSend : function( request ){
                               
                                $('.save_page_image_sort_order_wrap').addClass('loader');
                                $('.save_page_image_sort_order').hide();
                            },
                            success : function( data )
                                { 
                                    if(data.result=='success'){
                                        alertify.log(data.msg, 'success', 5000);
                                    }else{
                                        alertify.log(data.msg, 'error', 5000);
                                    }
                                    $('.save_page_image_sort_order_wrap').removeClass('loader');
                                    $('.save_page_image_sort_order').show();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'initialyze_sortable');
    

    $this->registerJs("
                    $(document).delegate('.slider_image_info_save_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        var title = $('.image_info_title'+id).val();
                        var desc = $('.image_info_desc'+id).val();


                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('slider/save_image_info')."',
                            data: {id:id,title:title,desc:desc},
                            beforeSend : function( request ){
                                $('.image_'+id+' .loader_img').show();
                            },
                            success : function( data )
                                { 
                                     $('.image_'+id+' .loader_img').hide();
                                     alertify.log(data.files.msg, 'success', 5000);
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'slider_image_info_save_btn');


    $this->registerJs("
                    $(document).delegate('.image_delete_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('slider/delete_uploaded_image')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 

                                    $('.image_'+id).remove();
                                    alertify.log(data.files.msg, 'success', 5000);
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'image_delete');

?>