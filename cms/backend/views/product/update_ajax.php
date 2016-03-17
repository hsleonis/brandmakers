<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\ProductCategory;
use kartik\checkbox\CheckboxX;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
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
                    <a href="javascript:;" class="btn btn-default btn-xs full-box full-box-modal">
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
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                      
                        <?php $form = ActiveForm::begin([
                            'id' => 'product-form-update',
                            'action' => ['product/update_ajax'],
                            'enableAjaxValidation' => false,
                            'enableClientValidation' =>  true,
                            
                        ]); ?>
                          <input type="hidden" name="Product[id]" value="<?php echo $model->id; ?>">
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

                              <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
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
                                    'multiple'=>true
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
                                        $(".uploaded_images").prepend(data.response.view);
                                        
                                    }',
                                    'filebatchuploadcomplete' => 'function(event, files, extra){
                                        $(".fileinput-remove-button").click();
                                    }',
                                    
                                ]
                            ]);
                        ?>

                        <div class="col-md-12">
                        <div class="row "><div class="row ">
                            <ul class="uploaded_images" style="margin-top:20px;">
                              <?php 

                                  if(!empty($model->product_image)){
                                      foreach ($model->product_image as $key) {
                              ?>
                                          <li class="col-md-4 product_image_<?php echo $key->id; ?>" image_id="<?php echo $key->id; ?>">
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
                                                          <label for="s_1">Is Banner Photo?</label>
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

                            <div class="col-md-12 save_sort_order_btn_wrap_product" style="">
                                <a class="btn btn-sm btn-primary pull-right save_sort_order_btn_product" href="#">Save Order</a>
                            </div>

                        </div></div>
                    </div>

                    </div>
                  </div>

                </div>
                
            </div>
        </div>

<?php

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

    

?>



