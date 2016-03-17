<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\models\Page;
use backend\models\Menu;
use backend\models\MenuPageRels;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
$this->title = 'Update Menus';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::base()."/files/jquery.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Url::base()."/files/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Url::base()."/files/jquery.mjs.nestedSortable.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Url::base()."/files/custom_drag.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile(Url::base()."/files/jquery-ui.css", [
    'media' => 'print',
], 'css-print-theme');


$this->registerJs("
                    get_menu();

                    $(document).delegate('.MENU_select', 'change', function() {

                        get_menu();
                    });
                    
                    function get_menu(){
                        var id = $('.MENU_select').val();
                        menu_id = id;
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('menu/get_menu')."',
                            data: {id:id,_csrf: yii.getCsrfToken()},
                            beforeSend : function( request ){
                                $('.sortable').fadeOut();
                            },
                            success : function( data )
                                { 
                                     $('.sortable').html(data.result);
                                     $('.sortable').fadeIn();
                                }
                        });

                    }

                    $('.save').click(function(){
                
                        data = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                        //data = dump(data);

                        url=$(this).attr('href');

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : url,
                            data: {menu_id:menu_id,data:data,_csrf:yii.getCsrfToken()},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                    alertify.log('Menu has been saved successfully.', 'success', 5000);
                                }
                        })
                    });
    ", yii\web\View::POS_END, 'MENU_select');


?>




<div class="menu-view">

    


    <style type="text/css">

        .placeholder {
            outline: 1px dashed #4183C4;
        }
        
        .mjs-nestedSortable-error {
            background: #fbe3e4;
            border-color: transparent;
        }
        
        #tree {
            width: 550px;
            margin: 0;
        }
        
        
        ol.sortable,ol.sortable ol {
            list-style-type: none;
        }
        
        .sortable li div {
            border: 1px solid #d4d4d4;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            cursor: move;
            border-color: #D4D4D4 #D4D4D4 #BCBCBC;
            margin: 0;
            padding: 3px;
        }
        
        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
        }
        
        .disclose, .expandEditor {
            cursor: pointer;
            width: 20px;
            display: none;
        }
        
        .sortable li.mjs-nestedSortable-collapsed > ol {
            display: none;
        }
        
        .sortable li.mjs-nestedSortable-branch > div > .disclose {
            display: inline-block;
        }
        
        .sortable span.ui-icon {
            display: inline-block;
            margin: 0;
            padding: 0;
        }
        
        .menuDiv {
            background: #EBEBEB;
        }
        
        .menuEdit {
            background: #FFF;
        }
        
        .itemTitle {
            vertical-align: middle;
            cursor: pointer;
        }
        
        .deleteMenu {
            float: right;
            cursor: pointer;
            height: 13px;
            width: 13px;
        }
        
        .notice {
            color: #c33;
        }
    </style>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                    <label>Select Menu</label>
                    <select name="MENU_select" class="form-control MENU_select">
                        <?php
                            $menus = Menu::find()->all();
                            foreach ($menus as $key) {
                                echo '<option value="'.$key->id.'">'.$key->title.'</option>';
                            }
                        ?>
                    </select>

            </div>
        </div>
        
    </div>

<div class="col-md-4">

                <div class="box dark full-screen-box">
                  <header>
                    <div class="icons">
                      <i class="fa fa-edit"></i>
                    </div>
                    <h5>Insert Item To Menu</h5>

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
                            <label class="control-label col-lg-4">Select Page</label>
                        <div class="col-lg-8">
                          
                            <select name="page_select" class="page_select form-control">
                                <?php
                                    $pages = Page::find()->all();
                                    foreach ($pages as $key) {
                                        echo '<option value="'.$key->id.'">'.$key->page_title.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label class="control-label col-lg-4">Item Title</label>
                        <div class="col-lg-8">
                           <input type="text" name="title" class="item_title form-control">
                        </div>
                      </div><!-- /.form-group -->

                      <div class="form-group">
                        <label class="control-label col-lg-4"></label>
                        <div class="col-lg-8">
                           <input type="button" class="add btn btn-primary btn-sm" value="Add To Menu">
                        </div>
                      </div><!-- /.form-group -->
                      
                    </form>
                  </div>
                </div>



        

       

        

        <input type="button" class="save btn btn-sm btn-primary pull-right" value="Save Menu" href="<?php echo Yii::$app->getUrlManager()->createUrl('menu/save_sorted_menu'); ?>">

        <!-- <h3>Try the custom methods:</h3>

        <p><input id="toArray" name="toArray" type="submit" value=
        "To array"></p>
        <pre id="toArrayOutput">
        </pre> -->

</div>

<div class="col-md-8">

    <section id="demo">
        <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nested Sortable-expanded">
            
        </ol>



    </section><!-- END #demo -->
</div>
















</div>
