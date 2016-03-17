<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\ProductCategory;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */

$this->title = 'Category List';
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::base()."/files/html.sortable.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
?>


<div class="col-md-4">
	<div class="row">
		<div class="col-md-12">

	        <div class="box dark full-screen-box">
	          <header>
	            <div class="icons">
	              <i class="fa fa-edit"></i>
	            </div>
	            <h5>Category List</h5>

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
	            <form class="form-horizontal">
	              <div class="form-group">
	                <label class="control-label col-lg-12" style="text-align:left; padding-bottom:5px;">Select Category</label>
	                <div class="col-lg-12">
	                  	<?php
	                       $data = ArrayHelper::map(ProductCategory::find()->joinWith('cat_rel')->where(['product_category_self_rel.parent_cat_id'=>0])->all(),'id','cat_title');
	                        
	                        echo Select2::widget([
	                            'model' => $ProductCategorySelfRel, 
	                            'attribute' => 'parent_cat_id',
	                            'data' => ProductCategory::getHierarchy_cat(),
	                            'options' => ['placeholder' => 'Select Category ...','multiple'=>false],
	                            'pluginOptions' => [
	                                'allowClear' => true
	                            ],
	                        ]);
	                    ?>
	                </div>
	              </div><!-- /.form-group -->
	              
	            </form>
	          </div>
	        </div>
	    </div>

	    <div class="col-md-12">

	        <div class="box dark full-screen-box">
	          <header>
	            <div class="icons">
	              <i class="fa fa-edit"></i>
	            </div>
	            <h5>Sub Category List</h5>

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
	            

	              <div class="sub_cat_cont"></div>
	              
	            
	          </div>
	        </div>
	    </div>

	</div>
</div>

<div class="col-md-8">
	<h4 class="category_title"></h4>
	<input type="hidden" class="category_id_hidden">
	<div class="category_product_cont" style="display:none;">
		<?=
        FileUploadUI::widget([
                        'model' => $model,
                        'attribute' => 'cat_title',
                        'url' => ['productcategory/upload_product'],
                        'gallery' => false,
                        'fieldOptions' => [
                                'accept' => 'image/*'
                        ],
                        'clientOptions' => [
                                'maxFileSize' => 2000000,
                                'downloadTemplateId' => null,
                        ],

                        'clientEvents' => [
                                'fileuploadsubmit' => 'function(e, data) {
                                                        var inputs = data.context.find(":input");
                                                        if (inputs.filter(function () {
                                                                return !this.value && $(this).prop("required");
                                                            }).first().focus().length) {
                                                            data.context.find("button").prop("disabled", false);
                                                            return false;
                                                        }
                                                        data.formData = inputs.serializeArray();
                                                        data.formData.push({"name":"id","value": $(".category_id_hidden").val()});
                                                        console.log(data.formData);
                                                    }',
                                'fileuploaddone' => 'function(e, data) {
                                                         console.log(data);
                                                        $.each(data._response.result.files, function (index, file) {
                                                            console.log(file.name);
                                                            
                                                        });

                                                        $(".category_product_list").append(data._response.result.view);

                                                    }',
                                'fileuploadfail' => 'function(e, data) {
                                                        console.log(e);
                                                        console.log(data);
                                                    }',
                                'fileuploaddestroy' => 'function(e, data) {
                                                        
                                                        console.log(data);
                                                    }',
                        ],
                    ]);
    ?>
	</div>


	<div class="row"><ul class="category_product_list sortable grid"></ul></div>

    <div class="col-md-12 save_sort_order_btn_wrap" style="display:none;"><a href="#" class="btn btn-sm btn-primary pull-right save_sort_order_btn">Save Order</a></div>

</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
                
      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
                
      </div>

    </div>
  </div>
</div>

<?php
    $this->registerJs("
        
        $('.sortable').sortable();

        $(document).delegate('.save_sort_order_btn', 'click', function() { 
            var data = [];
            $('.category_product_list li').each(function( key, value ) {
                data.push($(this).attr('data-id'));
            });
            
            var category = $('.category_id_hidden').val();

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('productcategory/save_sort_order')."',
                data: {data:data,category:category},
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
    ", yii\web\View::POS_READY, 'sorting');


    $this->registerJs("
            

            $(document).delegate('.save_sort_order_btn_product', 'click', function() { 
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
                       
                        $('.save_sort_order_btn_wrap_product').addClass('loader');
                        $('.save_sort_order_btn_product').hide();
                    },
                    success : function( data )
                        { 
                            if(data.result=='success'){
                                alertify.log(data.msg, 'success', 5000);
                            }else{
                                alertify.log(data.msg, 'error', 5000);
                            }
                            $('.save_sort_order_btn_wrap_product').removeClass('loader');
                            $('.save_sort_order_btn_product').show();
                        }
                });
                return false;
            });
        ", yii\web\View::POS_READY, 'save_product_image_sorting');
?>
<?php

	$this->registerJs("
                    $(document).delegate('#productcategoryselfrel-parent_cat_id', 'change', function() { 
                        var id = $(this).val();
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('productcategory/get_product_sub_cat')."',
                            data: {id:id},
                            beforeSend : function( request ){
                                $('.sub_cat_cont').html('');
                                $('.sub_cat_cont').addClass('loader');
                            },
                            success : function( data )
                                { 
                                    get_product_view(id);
                                    $('.sub_cat_cont').removeClass('loader');
                                    $('.sub_cat_cont').html(data.files.msg);
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'get_product_sub_cat');

    $this->registerJs("
                    $(document).delegate('.sub_cat_cont li a', 'click', function() { 
                        var id = $(this).attr('data_cat_id');
                        
                        get_product_view(id);

                        return false;
                    });

                    function get_product_view(id){
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('productcategory/product_view')."',
                            data: {id:id},
                            beforeSend : function( request ){
                                $('.category_product_list').html('');

                                $('.category_product_list').fadeIn();
                                $('.category_product_list').addClass('loader');
                                $('.save_sort_order_btn_wrap').show();
                            },
                            success : function( data )
                                { 
                                    $('.category_product_list').removeClass('loader');
                                    $('.category_title').html('You are here: Category - '+data.Category_name);
                                    $('.category_id_hidden').val(id);
                                    $('.category_product_list').html(data.upload_view);
                                    $('.category_product_cont').fadeIn();
                                     $('.sortable').sortable();
                                }
                        });
                    }
    ", yii\web\View::POS_READY, 'get_product_view');



?>

<?php

    $this->registerJs("
                    $(document).delegate('.update_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/get_update_data')."',
                            data: {id:id},
                            beforeSend : function( request ){
                                $('#myModal .modal-body').html('');
                                $('#myModal .modal-body').addClass('loader');
                                $('#myModal').modal('show');
                            },
                            success : function( data )
                                { 
                                    $('#myModal .modal-body').removeClass('loader');
                                	$('#myModal .modal-body').html(data.update_view);
                                    $('.uploaded_images').sortable();
                                    
                                }
                        });
                        return false;
                    });

    				$(document).delegate('#myModal .close-box', 'click', function() { 
                        $('#myModal').modal('hide');
                        return false;
                    });
    ", yii\web\View::POS_READY, 'product_update_form');


    $this->registerJs("
                    $(document).delegate('.view_btn_product', 'click', function() { 
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('product/get_product_view')."',
                            data: {id:id},
                            beforeSend : function( request ){
                                $('#myModal_view .modal-body').html('');
                                $('#myModal_view .modal-body').addClass('loader');
                                $('#myModal_view').modal('show');
                            },
                            success : function( data )
                                { 
                                    $('#myModal_view .modal-body').removeClass('loader');
                                    $('#myModal_view .modal-body').html(data.update_view);
                                    
                                }
                        });
                        return false;
                    });

    ", yii\web\View::POS_READY, 'product_view_form');

    
    

?>

<?php

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#product-form-update', 'beforeSubmit', function(event, jqXHR, settings) {
                        
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

                                            $('.product_view_image'+dt.id).html(dt.files);
                                            $('.product_view_label'+dt.id).html(dt.title);
                                            $('#myModal').modal('hide');
                                            alertify.log('Product has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'post_submit_update');

    
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