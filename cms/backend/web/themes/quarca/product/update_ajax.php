<?php

use yii\helpers\Html;

use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\ProductCategory;
use backend\models\ProductFiles;
use backend\models\ProductSpecItem;

use kartik\checkbox\CheckboxX;
use yii\widgets\Pjax;
use kartik\builder\TabularForm;
use \kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


        <div class="pane">
            <h2><span>Update Product Form</span></h2>
            <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Info</a></li>
                    <li role="presentation"><a href="#images" aria-controls="images" role="tab" data-toggle="tab">Product Images</a></li>
                    <li role="presentation"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Product Files</a></li>
                    <li role="presentation"><a href="#Specification" aria-controls="Specification" role="tab" data-toggle="tab">Product Specification</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="general">
                          
                            <?php $form = ActiveForm::begin([
                                'id' => 'product-form-update',
                                'action' => ['product/update_ajax'],
                                'enableAjaxValidation' => false,
                                'enableClientValidation' =>  true,
                                
                            ]); ?>
                              <input type="hidden" name="Product[id]" value="<?php echo $model->id; ?>">
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

                                  <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
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
                                        'multiple'=>true
                                    ],
                                    'pluginOptions' => [
                                        'uploadUrl' => Url::to(['/product/upload_image']),
                                        'uploadExtraData' => [
                                            'id' => $model->id,
                                            'cat_id' => 'Nature'
                                        ],
                                        'maxFileCount' => 10,
                                        'allowedFileExtensions' => ['jpg', 'png'],
                                        
                                    ],
                                    'pluginEvents' => [
                                        'fileuploaded'=>'function(event, data, previewId, index){
                                            $(".uploaded_images").prepend(data.response.view);
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

                                                            <div class="col-md-6" style="padding:0;">
                                                              <div class="" style="margin-top:5px;">
                                                                  
                                                                  <?= CheckboxX::widget([
                                                                      'name'=>'s_1'.$key->id,
                                                                      'value'=>$key->is_gallery,
                                                                      'options'=>['id'=>'isgallery_'.$key->id],
                                                                      'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                                  ]);?>
                                                                  <label for="s_1">Gallery?</label>
                                                              </div>
                                                            </div>


                                                            <div class="col-md-6" style="padding:0;">
                                                              <div class="" style="margin-top:5px;">
                                                              
                                                                  <?= CheckboxX::widget([
                                                                      'name'=>'s_2'.$key->id,
                                                                      'value'=>$key->is_banner,
                                                                      'options'=>['id'=>'isbanner_'.$key->id],
                                                                      'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                                                  ]);?>
                                                                  <label for="s_1">Banner?</label>
                                                              </div>
                                                            </div>

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

                                  <div class="col-md-12 save_sort_order_btn_wrap_product" style="">
                                      <a class="btn btn-sm btn-primary pull-right save_sort_order_btn_product" href="#">Save Order</a>
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
                                        'allowedFileExtensions' => ['doc', 'docx', 'pdf' , 'txt', 'xlsx', 'xls'],
                                        
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

                            <?php

                                Pjax::begin(['id' => 'countries']);
                                  

                                Pjax::end();
                                
                              ?>




                              <div class="col-md-6">
                                <div class="row">
                                  <div class="countries-form" style="display:none; padding:10px; background:#16a085;">
                             
                                      <?php $form = ActiveForm::begin([
                                                    'id' => 'product_spec-form-update',
                                                    'enableAjaxValidation' => false,
                                                    'enableClientValidation' =>  true,
                                                    'action' => ['product/update','id'=>$model->id],
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
                  </div>

                </div>
                
            </div>
        </div>

<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_product');

    
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
?>



