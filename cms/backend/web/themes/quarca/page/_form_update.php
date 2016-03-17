<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;/*
use dosamigos\ckeditor\CKEditor;*/
use backend\models\Page;
use backend\models\Post;
use backend\models\Tags;
//use dosamigos\fileupload\FileUploadUI;
use kartik\select2\Select2;
use kartik\file\FileInput;
use kartik\checkbox\CheckboxX;



/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */

    $this->registerJsFile(Url::base()."/files/html.sortable_product_image.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

    

?>

<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>
<div class="pane with_float">
    <div id="wizard">

            <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General Info</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Advanced Fields</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Upload Images</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Posts</a></li>
        </ul>


        <?php $form = ActiveForm::begin(); ?>
          <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">

                <section class="first_step">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="page_id" class="page_id_hidden" value="<?= $model->id; ?>">
                                


                                <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'page_slug')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'short_desc')->textArea() ?>
                                    
                                <?= $form->field($model, 'ext_url')->textInput() ?>

                                <?= $form->field($model, 'meta_key')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'meta_desc')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'date')->widget(
                                        DatePicker::className(), [
                                            'inline' => false, 
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd'
                                            ]
                                    ]);?>

                                <?php $form->field($model, 'status')
                                                        ->dropDownList(
                                                            array ('active'=>'Active', 'archive'=>'Archive') 
                                                        ); ?>


                        </div>

                        <div class="col-md-8">

                                
                                <?= $form->field($model, 'page_desc')->textArea(['rows' => '6','id'=>'editor2']) ?>
                                


                        </div>
                    </div>

                </section>

            </div>
            <div role="tabpanel" class="tab-pane" id="profile">

                <section class="first_step">
                    <div class="row">

                        <div class="col-md-3">
                                <label>Parent pages</label>
                                <?= 
                                   
                                    Select2::widget([
                                        'model' => $PageSelfRels_model, 
                                        'attribute' => 'parent_page_id',
                                        'data' => Page::getHierarchy_page(),
                                        'options' => ['placeholder' => 'Select parent page ...','multiple'=>true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>

                        </div>

                        <div class="col-md-3">
                                <?php
                                    $data = array ('Home'=>'Home', 
                                                       'Resume'=>'Resume', 
                                                       'About'=>'About', 
                                                       'Skills'=>'Skills', 
                                                       'Works'=>'Works', 
                                                       'Contact'=>'Contact',
                                                       'Service'=>'Service', 
                                                       'Project'=>'Project', 
                                                        )
                                ?>

                                <label>Page Types</label>
                                <?= Select2::widget([
                                        'model' => $PageTypeRel_model, 
                                        'attribute' => 'page_type',
                                        'data' => $data,
                                        'options' => ['placeholder' => 'Select page Type ...','multiple'=>true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>


                        </div>

                        <div class="col-md-3">
                                <label>Tags</label>
                                <?= 
                                   
                                    Select2::widget([
                                        'model' => $PageTagsRel_model, 
                                        'attribute' => 'tag_id',
                                        'data' => Tags::getAll(),
                                        'options' => ['placeholder' => 'Select parent page ...','multiple'=>true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>

                        </div>

                        
                    </div>

                </section>

            </div>
            <div role="tabpanel" class="tab-pane" id="messages">

                <section>
                        
                    <?= FileInput::widget([
                            'model' => $PageImageRel_model,
                            'attribute' => 'image',
                            'options'=>[
                                'multiple'=>true
                            ],
                            'pluginOptions' => [
                                'uploadUrl' => Url::to(['/page/upload_file']),
                                'uploadExtraData' => [
                                    'id' => $model->id,
                                    'cat_id' => 'Nature'
                                ],
                                'maxFileCount' => 10,
                                'allowedFileExtensions' => ['jpg', 'png'],
                                
                            ],
                            'pluginEvents' => [
                                'fileuploaded'=>'function(event, data, previewId, index){
                                    $(".uploaded_images").append(data.response.view);
                                    $(".sortable").sortable();
                                }',
                                'filebatchuploadcomplete' => 'function(event, files, extra){
                                    $(".fileinput-remove-button").click();
                                    $(".sortable").sortable();
                                }',
                                
                            ]
                        ]);
                    ?>

                                <ul class="row uploaded_images sortable grid">

                                    <?php 

                                        if(!empty($image_rel_model)){
                                            foreach ($image_rel_model as $key) {
                                    ?>
                                                <li class="col-md-3 image_<?php echo $key->id; ?>" image_id="<?php echo $key->id; ?>" style="position:relative;">
                                                    <div class="loader_img"></div>
                                                    <div class="pane uploaded_image_container" style="padding:0px;">
                                                        <div class="uploaded_image_wrap">
                                                            <img src="<?php echo Url::base().'/uploads/' .$key->image; ?>" alt="<?php echo $key->image; ?>" width="100%">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Short Title</label>
                                                            <input type="text" name="short_title" value="<?= $key->short_title; ?>" class="form-control page_image_info_title<?php echo $key->id; ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Short Description</label>
                                                            <input type="text" name="short_desc" value="<?= $key->short_desc; ?>" class="form-control page_image_info_desc<?php echo $key->id; ?>">
                                                        </div>

                                                        <div class="" style="margin-top:5px;">
                                                            <label for="s_1">Is Gallery Photo?</label>
                                                            <?= CheckboxX::widget([
                                                                'name'=>'s_1'.$key->id,
                                                                'value'=>$key->is_gallery,
                                                                'options'=>['id'=>'isgallery_'.$key->id],
                                                                'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                            ]);?>
                                                        </div>


                                                        <div class="" style="margin-top:5px;">
                                                            <label for="s_1">Is Banner Photo?</label>
                                                            <?= CheckboxX::widget([
                                                                'name'=>'s_2'.$key->id,
                                                                'value'=>$key->is_banner,
                                                                'options'=>['id'=>'isbanner_'.$key->id],
                                                                'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                            ]);?>
                                                        </div>


                                                        <div class="image_upload_cont_btn_panel">
                                                            <button name="save" class="btn btn-xs btn-primary page_image_info_save_btn" data_id="<?php echo $key->id; ?>">Save</button>
                                                            <button name="save" class="btn btn-xs btn-default image_delete_btn" data_id="<?php echo $key->id; ?>">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                    <?php
                                            }
                                        }

                                    ?>
                                </ul>

                    <div class="text-right">
                        <div class="save_page_image_sort_order_wrap" style="display: inline-table;">
                            <input type="button" class="btn btn-sm btn-primary pull-right save_page_image_sort_order" value="Save Sort Order">
                        </div>
                    </div>

                </section>

            </div>
            <div role="tabpanel" class="tab-pane" id="settings">

                <section>
                    
                        <div class="col-md-12">
                            <div class="pane">
                                <input type="button" class="btn btn-sm btn-default create_post" value="Create Post">
                                
                                <div class="list_of_post">
                                    <?= $this->render('/post/list_of_post', [
                                        'page_id' => $model->id
                                    ]) ?>
                                </div>
                                <div class="col-md-12" style="margin-top:30px;">
                                    <div class="row post_sort_order_wrap">
                                        <input type="button" class="btn btn-sm btn-primary pull-right post_sort_order" value="Save Post Sort Order">
                                    </div>
                                </div>
                                
                                <label></label>
                            </div>
                        </div>

                        <div class="form-group col-md-12 update_page_btn_wrap">
                            <?= Html::submitButton('Update Page', ['class' => 'btn btn-primary']) ?>
                        </div>
                </section>

            </div>
        </div>
     <?php ActiveForm::end(); ?>       
                
        
            

    </div>
</div>

                            
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Post</h4>
      </div>
      <div class="modal-body">
                <div class="post">
                    <?php $post_model = new Post(); ?>
                    <?= $this->render('/post/_form', [
                        'model' => $post_model,
                        'page_id' => $model->id
                    ]) ?>
                </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="myModal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Update Post</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
            <div class="post">
                <?php $post_model = new Post(); ?>
                <?= $this->render('/post/_form_update', [
                    'model' => $post_model,
                    'page_id' => $model->id
                ]) ?>
            </div>
        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal -->



<!-- Modal -->
<div class="modal fade" id="myModal_post_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Post</h4>
      </div>
      <div class="modal-body">
                
      </div>
      
    </div>
  </div>
</div>

<?php
    $this->registerJs("
                    $(document).delegate('.image_delete_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('page/delete_uploaded_file')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     $('.image_'+id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'image_delete');


    $this->registerJs("
                    $(document).delegate('.image_delete_btn_post', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('post/delete_uploaded_file')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     $('.post_image_'+id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'image_delete_post');

    $this->registerJs("
                    $(document).delegate('.view_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('post/view')."',
                            data: {id:id},
                            beforeSend : function( request ){
                                $('#myModal_post_view .modal-body').html('');
                                $('#myModal_post_view .modal-body').addClass('loader');
                                $('#myModal_post_view').modal('show');
                            },
                            success : function( data )
                                {   
                                    $('#myModal_post_view .modal-body').removeClass('loader');
                                    $('#myModal_post_view .modal-body').html(data.view);
                                     
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'view_post_btn');

    $this->registerJs("
                    $(document).delegate('.delete_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('post/delete')."',
                            data: {id:id},
                            beforeSend : function( request ){
                            },
                            success : function( data )
                                {   
                                    $('.Post_'+id).remove();
                                     
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'delete_post_btn');

    $this->registerJs("
                    $(document).delegate('.page_image_info_save_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        var title = $('.page_image_info_title'+id).val();
                        var desc = $('.page_image_info_desc'+id).val();
                        var is_gallery = $('#isgallery_'+id).val();
                        var is_banner = $('#isbanner_'+id).val();


                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('page/save_image_info')."',
                            data: {id:id,title:title,desc:desc,is_gallery:is_gallery,is_banner:is_banner},
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
    ", yii\web\View::POS_READY, 'page_image_info_save_btn');


    
    $this->registerJs("
        
        $('.sortable').sortable();

        $(document).delegate('.save_page_image_sort_order', 'click', function() { 
            var data = [];
            $('.uploaded_images li').each(function( key, value ) {
                data.push($(this).attr('image_id'));
            });
            
            var page = $('.page_id_hidden').val();

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('page/save_page_image_sort_order')."',
                data: {data:data,page:page},
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
    ", yii\web\View::POS_READY, 'save_product_image_sorting');


    $this->registerJs("
        
        $('.post_sort').sortable();

        $(document).delegate('.post_sort_order', 'click', function() { 
            var data = [];
            $('.post_sort li').each(function( key, value ) {
                data.push($(this).attr('data-id'));
            });
            
            var page = $('.page_id_hidden').val();

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('post/save_post_sort_order')."',
                data: {data:data,page:page},
                beforeSend : function( request ){
                   
                    $('.post_sort_order_wrap').addClass('loader');
                    $('.post_sort_order').hide();
                },
                success : function( data )
                    { 
                        if(data.result=='success'){
                            alertify.log(data.msg, 'success', 5000);
                            $('.list_of_post').html(data.post_list);
                            $('.post_sort').sortable();
                        }else{
                            alertify.log(data.msg, 'error', 5000);
                        }
                        $('.post_sort_order_wrap').removeClass('loader');
                        $('.post_sort_order').show();
                    }
            });
            return false;
        });
    ", yii\web\View::POS_READY, 'save_post_sorting');


    $this->registerJs('
            
            CKEDITOR.replace( "editor2", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });

            CKEDITOR.replace( "editor1", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });

            CKEDITOR.replace( "editor3", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_post');


    $this->registerJs("
                    $(document).delegate('.update_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('post/update')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                    $('.uploaded_post_image_cont').html(data.images_list);
                                    $('#image_tab_cont').html(data.upload_view);
                                    $('#upd_post_id').val(data.id);
                                    $('#myModal_update #post-post_title').val(data.post_title);
                                    CKEDITOR.instances.editor3.setData(data.desc);
                                    $('#myModal_update').modal('show');
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_END, 'update_post_btn');

    $this->registerJs("
                        $(document).delegate('.create_post', 'click', function() { 
                            $('#myModal').modal('show');
                        });
    ", yii\web\View::POS_END, 'create_post');
?>