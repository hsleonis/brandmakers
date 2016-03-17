<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\ProductCategory;
use backend\models\ProductSpecItem;
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


        <div class="box dark full-screen-box">
            <header>
                <div class="icons">
                  <i class="fa fa-edit"></i>
                </div>
                <h5>Update Product Form</h5>

                <!-- .toolbar -->
                <div class="toolbar">
                  <nav style="padding: 8px;">
                    <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
                      <i class="fa fa-minus"></i>
                    </a> 
                    <a href="javascript:;" class="btn btn-default btn-xs full-box">
                      <i class="fa fa-expand fa-compress"></i>
                    </a> 
                    <a href="javascript:;" class="btn btn-danger btn-xs close-box">
                      <i class="fa fa-times"></i>
                    </a> 
                  </nav>
                </div><!-- /.toolbar -->
            </header>
            <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General Info</a></li>
                      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Images</a></li>
                      <li role="presentation"><a href="#Specification" aria-controls="Specification" role="tab" data-toggle="tab">Product Specification</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="home">
                        
                          <?php $form = ActiveForm::begin([
                              'id' => 'product_update-form',
                          ]); ?>

                            <div class="col-md-4">
                                <div class="row">

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

                                    <?= $form->field($model, 'model')->textInput(['maxlength' => 255]) ?>

                                    <?= $form->field($model, 'size')->textInput(['maxlength' => 255]) ?>

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
                            </div>
                            
                            <div class="col-md-8">
                                <?= $form->field($model, 'desc')->textArea(['rows' => '6','id'=>'editor']) ?>

                                <?= Html::submitButton('Update', ['class' => 'btn btn-default']) ?>
                            </div>

                            

                            

                            <div class="form-group">
                                
                            </div>

                          <?php ActiveForm::end(); ?>

                      </div>
                      <div role="tabpanel" class="tab-pane" id="profile">
                        
                          <?= FileInput::widget([
                                  'model' => $ProductImageRel,
                                  'attribute' => 'image',
                                  'options'=>[
                                      'multiple'=>true,
                                      'accept' => 'image/*'
                                  ],
                                  'pluginOptions' => [
                                      'uploadUrl' => Url::to(['/product/upload_file']),
                                      'uploadExtraData' => [
                                          'id' => $model->id,
                                          'cat_id' => 'Nature'
                                      ],
                                      'maxFileCount' => 10,
                                      
                                      
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

                                                          <div class="col-md-12"><div class="row" style="margin-top:5px;">
                                                              <label for="s_1">Is Gallery Photo?</label>
                                                              <?= CheckboxX::widget([
                                                                  'name'=>'s_1'.$key->id,
                                                                  'value'=>$key->is_gallery,
                                                                  'options'=>['id'=>'isgallery_'.$key->id],
                                                                  'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                              ]);?>
                                                          </div></div>


                                                          <div class="col-md-12"><div class="row" style="margin-top:5px;">
                                                              <label for="s_2">Is Banner Photo?</label>
                                                              <?= CheckboxX::widget([
                                                                  'name'=>'s_2'.$key->id,
                                                                  'value'=>$key->is_banner,
                                                                  'options'=>['id'=>'isbanner_'.$key->id],
                                                                  'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                              ]);?>
                                                          </div></div>

                                                      <div class="image_upload_cont_btn_panel">
                                                          <button name="save" class="btn btn-xs btn-primary image_save_btn_product" data_id="<?php echo $key->id; ?>">Save</button>
                                                          <button name="save" class="btn btn-xs btn-default image_delete_btn_product" data_id="<?php echo $key->id; ?>">Delete</button>
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
                                                  Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
                                                  Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary tabular_save_btn'])
                                      ]
                                  ]   
                              ]);
                              ActiveForm::end();

                            Pjax::end();
                            
                          ?>
                          
                          </div>
                      </div>
                  </div>

                </div>
                
            </div>
        </div>

<?php
  
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



    $this->registerJs('
            var editor = CKEDITOR.instances["editor"];
                    if (editor) { editor.destroy(true); }
            
            CKEDITOR.replace( "editor", {
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_product');

    $this->registerJs("
                    $(document).delegate('.image_delete_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/delete_uploaded_file')."',
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
                    $(document).delegate('.image_save_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        var title = $('.short_title_product'+id).val();
                        var desc = $('.short_desc_product'+id).val();
                        var is_gallery = $('#isgallery_'+id).val();
                        var is_banner = $('#isbanner_'+id).val();

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/save_product_image_details')."',
                            data: {id:id,title:title,desc:desc,is_gallery:is_gallery,is_banner:is_banner},
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




<!-- Modal -->
<div class="modal fade" id="myModal_create_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
                
        <div class="countries-form">
 
          <?php $form = ActiveForm::begin([
                        'id' => 'cat-form-update',
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



<?php

  $this->registerJs("
            $(document).ready(
                    $(document).delegate('#cat-form-update', 'beforeSubmit', function(event, jqXHR, settings) {
                        
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
                                            $('#countries').html(dt.post_list);

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
                      $('#countries').html(data.post_list);
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