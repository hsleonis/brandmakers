<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\ProductCategory;
use backend\models\ProductSpecItem;
use backend\models\ProductFiles;
use backend\models\ProductPost;
use kartik\checkbox\CheckboxX;

use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use \kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Url::base()."/files/html.sortable_product_image.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>

<div class="pane" style="float:left; width:100%;">
  <h2><span>Update Product Form</span></h2>


      <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Info</a></li>
            <li role="presentation"><a href="#images" aria-controls="images" role="tab" data-toggle="tab">Product Images</a></li>
            <li role="presentation"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Product Files</a></li>
            <li role="presentation"><a href="#Specification" aria-controls="Specification" role="tab" data-toggle="tab">Product Specification</a></li>
            <li role="presentation"><a href="#Posts" aria-controls="Posts" role="tab" data-toggle="tab">Product Posts</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" style="padding:15px 0;">
            <div role="tabpanel" class="tab-pane active" id="general">
                <input type="hidden" name="product_id" class="product_id_hidden" value="<?= $model->id; ?>">
                <?php $form = ActiveForm::begin([
                    'id' => 'product_update-form',
                ]); ?>

                  <div class="col-md-4">

                        <input type="hidden" name="id" value="<?= $model->id; ?>" id="product_id">

                          <?= Html::activeLabel($ProductCategoryRel,'category_id'); ?>
                          <?= 
                              Select2::widget([
                                  'model' => $ProductCategoryRel, 
                                  'attribute' => 'category_id',
                                  'data' => ProductCategory::getHierarchy_cat(),
                                  'options' => ['placeholder' => 'Select Category ...','multiple'=>true],
                                  'pluginOptions' => [
                                      'allowClear' => true
                                  ],
                              ]);
                          ?>

                          <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
                          <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
                      
                          <?= $form->field($model, 'sort_order')->textInput(['maxlength' => 255]) ?>

                            <?php
                                $data = array ('1'=>'Yes', 
                                               '0'=>'No', 
                                                )
                            ?>

                            <label>Is Featured?</label>
                            <?= Select2::widget([
                                    'model' => $model, 
                                    'attribute' => 'is_featured',
                                    'data' => $data,
                                    'options' => ['placeholder' => 'Select one ...','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>

                          <?php
                              $data = array ('1'=>'Active', 
                                             '0'=>'Inactive', 
                                              )
                          ?>

                          <label>Status</label>
                          <?= Select2::widget([
                                  'model' => $model, 
                                  'attribute' => 'status',
                                  'data' => $data,
                                  'options' => ['placeholder' => 'Select Status ...','multiple'=>false],
                                  'pluginOptions' => [
                                      'allowClear' => true
                                  ],
                              ]); ?>

                  </div>
                  
                  <div class="col-md-8">
                      <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor']) ?>

                      <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                  </div>

                  

                  

                  <div class="form-group">
                      
                  </div>

                <?php ActiveForm::end(); ?>

            </div>


            <div role="tabpanel" class="tab-pane" id="images">
              
                <?= FileInput::widget([
                        'model' => $ProductImageRel,
                        'attribute' => 'image',
                        'options'=>[
                            'multiple'=>true,
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'uploadUrl' => Url::to(['/product/upload_image']),
                            'uploadExtraData' => [
                                'id' => $model->id,
                                'cat_id' => 'Nature'
                            ],
                            'maxFileCount' => 20,
                            'previewFileType' => 'image',
                            'allowedFileExtensions' => ['jpg', 'png'],
                            
                        ],
                        'pluginEvents' => [
                            'fileuploaded'=>'function(event, data, previewId, index){
                                $(".uploaded_images").append(data.response.view);
                                $(".uploaded_images").sortable();
                                
                            }',
                            'filebatchuploadcomplete' => 'function(event, files, extra){
                                $(".fileinput-remove-button").click();
                            }',
                            
                        ]
                    ]);
                ?>

                <div class="col-md-12">
                  <div class="row ">
                      <ul class="uploaded_images" style="margin-top:20px;">
                        <?php 

                            if(!empty($model->product_image)){
                                foreach ($model->product_image as $key) {
                        ?>
                                    <li class="col-md-3 product_image_<?php echo $key->id; ?>" image_id="<?php echo $key->id; ?>">
                                        <div class="image_cont">
                                            <div class="uploaded_image_wrap">
                                                <img src="<?php echo Url::base().'/product_uploads/' .$key->image; ?>" alt="<?php echo $key->image; ?>" width="100%">
                                            </div>
                                            <label>Short Title</label>
                                            <input type="text" name="short_title" class="short_title_product<?php echo $key->id; ?>" value="<?php echo $key->title; ?>">
                                            <label>Short Description</label>
                                            <input type="text" name="short_desc" class="short_desc_product<?php echo $key->id; ?>" value="<?php echo $key->desc; ?>">

                                                <div class="col-md-6" style="padding:0;"><div style="margin-top:5px;">
                                                    
                                                    <?= CheckboxX::widget([
                                                        'name'=>'s_1'.$key->id,
                                                        'value'=>$key->is_gallery,
                                                        'options'=>['id'=>'isgallery_'.$key->id],
                                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                    ]);?>
                                                    <label for="s_1">Gallery?</label>
                                                </div></div>


                                                <div class="col-md-6" style="padding:0;"><div style="margin-top:5px;">
                                                    
                                                    <?= CheckboxX::widget([
                                                        'name'=>'s_2'.$key->id,
                                                        'value'=>$key->is_banner,
                                                        'options'=>['id'=>'isbanner_'.$key->id],
                                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                    ]);?>
                                                    <label for="s_1">Banner?</label>
                                                </div></div>

                                                <div class="col-md-6" style="padding:0;"><div style="margin-top:5px;">
                                                    
                                                    <?= CheckboxX::widget([
                                                        'name'=>'s_3'.$key->id,
                                                        'value'=>$key->is_hover,
                                                        'options'=>['id'=>'ishover'.$key->id],
                                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                    ]);?>
                                                    <label for="s_1">Hover?</label>
                                                </div></div>

                                            <div class="image_upload_cont_btn_panel col-md-12" style="padding:0;">
                                                <button name="save" class="btn btn-xs btn-primary image_save_btn_product" data_id="<?php echo $key->id; ?>">Save</button>
                                                <button name="save" class="btn btn-xs btn-danger image_delete_btn_product" data_id="<?php echo $key->id; ?>">Delete</button>
                                            </div>
                                        </div>
                                    </li>
                        <?php
                                }
                            }

                        ?>
                      </ul>

                      <div class="col-md-12 save_sort_order_btn_wrap" style="">
                          <a class="btn btn-sm btn-primary pull-right save_sort_order_btn" href="#">Save Order</a>
                      </div>
                  </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="files">
              <?php
                    $files_model = new ProductFiles();
                    echo FileInput::widget([
                        'model' => $files_model,
                        'attribute' => 'file_name',
                        'options'=>[
                            'multiple'=>true
                        ],
                        'pluginOptions' => [
                            'uploadUrl' => Url::to(['/product/upload_file']),
                            'uploadExtraData' => [
                                'id' => $model->id,
                            ],
                            'maxFileCount' => 10,
                            'allowedFileExtensions' => ['docx', 'doc', 'txt', 'pdf'],
                            
                        ],
                        'pluginEvents' => [
                            'fileuploaded'=>'function(event, data, previewId, index){
                                $(".product_files_table").append(data.response.view);
                                //$(".uploaded_images").sortable();
                                
                            }',
                            'filebatchuploadcomplete' => 'function(event, files, extra){
                                $(".fileinput-remove-button").click();
                            }',
                            
                        ]
                    ]);
                ?>


                <div class="col-md-8">
                    <table class="table product_files_table">
                      <tr>
                        <th>File Name</th>
                        <th>File</th>
                        <th>Actions</th>
                      </tr>
                        <?php 

                            if(!empty($model->product_files)){
                                foreach ($model->product_files as $key) {
                        ?>

                                <tr class="product_file_<?= $key->id; ?>">
                                  <td><?= $key->title; ?></td>
                                  <td><?= $key->file_name; ?></td>
                                  <td><a href="" class="btn btn-xs btn-primary file_remove_btn" data_id="<?php echo $key->id; ?>">Remove</a></td>
                                </tr>
                                    
                        <?php
                                }
                            }

                        ?>

                    </table>
                </div>
            </div>


            <div role="tabpanel" class="tab-pane" id="Specification">
              <div class="col-md-8">

                  <?php

                    Pjax::begin(['id' => 'countries']);
                      $form = ActiveForm::begin();
                      


                      echo TabularForm::widget([
                          'dataProvider'=>$dataProvider,
                          'form'=>$form,
                          'attributes'=>$model_q->formAttribs,
                          'gridSettings'=>[
                              'floatHeader'=>true,
                              'panel'=>[
                                  'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
                                  'type' => GridView::TYPE_PRIMARY,
                                  'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success create_cat_btn']) . ' ' . 
                                          //Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
                                          Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary tabular_save_btn'])
                              ]
                          ]   
                      ]);
                      ActiveForm::end();

                    Pjax::end();
                    
                  ?>
                
              </div>

              <div class="col-md-4">
                <div class="pane" style="padding:0;">
                  <h2><span>Preview</span></h2>
                    <div class="preview_cont">
                      
                    </div>
                </div>
              </div>
            </div>


            <div role="tabpanel" class="tab-pane" id="Posts">
              
                <div class="col-md-12">
                  <div class="pane">
                      <input type="button" name="post" class="btn btn-primary create_post" value="Create Post">

                      <div class="list_of_post">
                          <?= $this->render('/productpost/list_of_post', [
                              'product_id' => $model->id
                          ]) ?>
                      </div>


                  </div>
                </div>

            </div>


        </div>

      </div>

</div>            





<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Post</h4>
      </div>
      <div class="modal-body">
                <div class="post">
                    <?php $post_model = new ProductPost(); ?>
                    <?= $this->render('/productpost/_form', [
                        'model' => $post_model,
                        'product_id' => $model->id
                    ]) ?>
                </div>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="post_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Update Post</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
            <div class="post">
                <?php $post_model = new ProductPost(); ?>
                <?= $this->render('/productpost/_form_update', [
                    'model' => $post_model,
                    'product_id' => $model->id
                ]) ?>
            </div>
        </div><!-- /modal-body -->
        
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal -->





<!-- Modal -->
<div class="modal modal-primary fade" id="myModal_create_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
        <h4 id="myModalLabel2" class="modal-title">Add Product Specification</h4>
      </div>
      
      <div class="modal-body">
                
        <div class="countries-form">
 
          <?php $form = ActiveForm::begin([
                        'id' => 'product_spec-form-update',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' =>  true,
                        
                    ]); ?>
         
              <label>Item Name</label>
              <?= Select2::widget([
                      'model' => $model_q, 
                      'attribute' => 'item_name',
                      'data' => ArrayHelper::map(ProductSpecItem::find()->asArray()->all(), 'name', 'name'),
                      'options' => ['placeholder' => 'Select Item Name ...','multiple'=>false],
                      'pluginOptions' => [
                          'allowClear' => true
                      ],
                  ]); ?>
              <?= $form->field($model_q, 'item_val')->textInput(['maxlength' => 200]) ?>
              <input type="hidden" maxlength="200" name="ProductSpecification[cat_create]" class="form-control" value="ok">
              <input type="hidden" maxlength="200" name="ProductSpecification[product_id]" class="form-control" value="<?= $model->id;?>">
           
           
              <div class="form-group">
                  <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
              </div>
           
          <?php ActiveForm::end(); ?>
        </div>

      </div>

    </div>
  </div>
</div>



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
                    $(document).delegate('.delete_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('productpost/delete')."',
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
                    $(document).delegate('.view_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('productpost/view')."',
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
                    $(document).delegate('.update_post_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('productpost/update')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                    $('.uploaded_post_image_cont').html(data.images_list);
                                    $('#image_tab_cont').html(data.upload_view);
                                    $('#upd_post_id').val(data.id);
                                    $('#post_update #productpost-post_title').val(data.post_title);
                                    $('#post_update #productpost-slug').val(data.slug);
                                    CKEDITOR.instances.editor3.setData(data.desc);
                                    $('#post_update').modal('show');
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_END, 'update_post_btn');


    $this->registerJs("
                    $('.post_sort').sortable();


                    $('.post_sort').sortable().bind('sortupdate', function(e, ui) {
                        sort()
                    })

                    function sort(){
                        var data = [];
                            $('.post_sort li').each(function( key, value ) {
                                data.push($(this).attr('data-id'));
                            });
                            
                            var product = $('.product_id_hidden').val();

                            $.ajax({
                                type : 'POST',
                                dataType : 'json',
                                url : '".Url::toRoute('productpost/save_post_sort_order')."',
                                data: {data:data,product:product},
                                beforeSend : function( request ){
                                   
                                    $('.post_sort_order_wrap').addClass('loader');
                                    $('.post_sort_order').hide();
                                },
                                success : function( data )
                                    { 
                                        if(data.result=='success'){
                                            //alertify.log(data.msg, 'success', 5000);
                                            $('.list_of_post').html(data.post_list);


                                            $('.post_sort').sortable();
                                            $('.post_sort').sortable().bind('sortupdate', function(e, ui) {
                                                sort();
                                                return false;
                                            });

                                        }else{
                                            alertify.log(data.msg, 'error', 5000);
                                        }
                                        $('.post_sort_order_wrap').removeClass('loader');
                                        $('.post_sort_order').show();
                                    }
                            })
                    }


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
                                            $('.post_sort').sortable().bind('sortupdate', function(e, ui) {
                                                sort();
                                                return false;
                                            });
                                            sort();

                                            alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })

    ", yii\web\View::POS_END, 'product_post_submit_update');



    $this->registerJs("
                        $(document).delegate('.create_post', 'click', function() { 
                            $('#postModal').modal('show');
                        });
    ", yii\web\View::POS_END, 'create_post');

    $this->registerJs('

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
                                            sort();
                                            
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
  
    $this->registerJs("
        
        $('.uploaded_images').sortable();

        $(document).delegate('.save_sort_order_btn', 'click', function() { 
            var data = [];
            $('.uploaded_images li').each(function( key, value ) {
                data.push($(this).attr('image_id'));
            });
            
            var product = $('#product_id').val();

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('product/save_sort_order')."',
                data: {data:data,product:product},
                beforeSend : function( request ){
                   
                    $('.save_sort_order_btn_wrap').addClass('loader');
                    $('.save_sort_order_btn').hide();
                },
                success : function( data )
                    { 
                        if(data.result=='success'){
                            alertify.log(data.msg, 'success', 5000);
                        }else{
                            alertify.log(data.msg, 'error', 5000);
                        }
                        $('.save_sort_order_btn_wrap').removeClass('loader');
                        $('.save_sort_order_btn').show();
                    }
            });
            return false;
        });
    ", yii\web\View::POS_READY, 'save_product_image_sorting');



    $this->registerJs("
            var editor = CKEDITOR.instances['editor'];
                    if (editor) { editor.destroy(true); }
            
            CKEDITOR.replace( 'editor', {
                 customConfig: '".Url::base()."/ckeditor/config/".Yii::$app->params['editor']."/config.js',
                 filebrowserBrowseUrl: '".Url::base()."/kcfinder/browse.php?type=files',
                 filebrowserImageBrowseUrl: '".Url::base()."/kcfinder/browse.php?type=images',
                 filebrowserFlashBrowseUrl: '".Url::base()."/kcfinder/browse.php?type=flash',
                 filebrowserUploadUrl: '".Url::base()."/kcfinder/upload.php?type=files',
                 filebrowserImageUploadUrl: '".Url::base()."/kcfinder/upload.php?type=images',
                 filebrowserFlashUploadUrl: '".Url::base()."/kcfinder/upload.php?type=flash',
            });

    ", yii\web\View::POS_READY, 'ck_editor_product');

    $this->registerJs("
                    $(document).delegate('.image_delete_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/delete_uploaded_image')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     $('.product_image_'+id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'product_image_delete');


    $this->registerJs("
                    $(document).delegate('.file_remove_btn', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/delete_uploaded_file')."',
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     $('.product_file_'+id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'file_remove_btn');


    $this->registerJs("
                    $(document).delegate('.image_save_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        var title = $('.short_title_product'+id).val();
                        var desc = $('.short_desc_product'+id).val();
                        var is_gallery = $('#isgallery_'+id).val();
                        var is_banner = $('#isbanner_'+id).val();
                        var is_hover = $('#ishover'+id).val();

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/save_product_image_details')."',
                            data: {id:id,title:title,desc:desc,is_gallery:is_gallery,is_banner:is_banner,is_hover:is_hover},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     alertify.log(data.files.msg, 'success', 5000);
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'image_save_product');

?>



<?php

  $this->registerJs("
            $(document).ready(
                    $(document).delegate('#product_spec-form-update', 'beforeSubmit', function(event, jqXHR, settings) {
                        
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
                                            $('#countries').html(dt.specification_list);
                                            $('.preview_cont').html(dt.preview_cont);
                                            $('#myModal_create_cat').modal('hide');

                                            alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })

            );

      $(document).delegate('.create_cat_btn', 'click', function() {
        $('#myModal_create_cat').modal('show');
        return false;
      });

    ", yii\web\View::POS_END, 'post_submit_update');


    $this->registerJs("
      $('.nav-tabs li a').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr('href');

        if ((target == '#Specification')) {
          var is_banner = 'ok';

          $.ajax({
              type : 'POST',
              dataType : 'json',
              url : '".Url::toRoute(['product/update','id'=>$model->id])."',
              data: {is_banner:is_banner},
              beforeSend : function( request ){
                $('#countries').html('');
                $('#countries').addClass('loader');
              },
              success : function( data )
                  { 
                      $('#countries').removeClass('loader');
                      $('#countries').html(data.specification_list);
                      $('.preview_cont').html(data.preview_cont);
                  }
          });
        }

      });
          
    ", yii\web\View::POS_READY, 'ajax_load_first');

  $this->registerJs("
            $(document).ready(
                    $(document).delegate('#countries #w0', 'beforeSubmit', function(event, jqXHR, settings) {
                        
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

                                            alertify.log(dt.files, 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );


    ", yii\web\View::POS_END, 'gjgjghjgj');

?>