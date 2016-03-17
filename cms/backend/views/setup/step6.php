<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;

$this->title = 'Select Modules';

?>

<div class="site-index">


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 box_slide_down" style="background:#fff; display:none;">
                <div class="box dark full-screen-box">
                    <header>
                        <div class="icons">
                          <i class="fa fa-edit"></i>
                        </div>
                        <h5>Select Modules</h5>

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

                        <div class="tags-form">

                            <div class="form-group">
                                
                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'product',
                                        'value'=>'0',
                                        'options'=>['id'=>'product'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Product Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'user',
                                        'value'=>'0',
                                        'options'=>['id'=>'user'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">User Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'slider',
                                        'value'=>'1',
                                        'options'=>['id'=>'slider'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Slider Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'category',
                                        'value'=>'1',
                                        'options'=>['id'=>'category'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Category Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'timeline',
                                        'value'=>'0',
                                        'options'=>['id'=>'timeline'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Timeline</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'RBAC',
                                        'value'=>'1',
                                        'options'=>['id'=>'RBAC'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">RBAC Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'settings',
                                        'value'=>'1',
                                        'options'=>['id'=>'settings'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Settings Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'mail',
                                        'value'=>'1',
                                        'options'=>['id'=>'mail'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Mail Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'menu',
                                        'value'=>'0',
                                        'options'=>['id'=>'menu'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Menu Module</label>
                                </div>

                                <div class="col-md-4" style="margin-bottom:10px;">
                                    <?= CheckboxX::widget([
                                        'name'=>'tags',
                                        'value'=>'0',
                                        'options'=>['id'=>'tags'],
                                        'pluginOptions'=>['threeState'=>false,'size'=>'sm']
                                    ]);?>
                                    <label for="text1" class="control-label">Tags Module</label>
                                </div>

                                <div class="col-md-12" style="margin-bottom:10px;">
                                    <a href="<?php echo Url::toRoute('/site/login',true); ?>" class="btn btn-sm btn-primary pull-right finish_btn">Finish</a>
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

    $this->registerJs("
                    $('.box_slide_down').slideDown('slow');

                    $('.finish_btn').on('click', function() { 
                        
                        var url = $(this).attr('href');
                        var status = 'Installed';

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('setup/step6')."',
                            data: {status:status},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                        alertify.log(data.msg, 'success', 5000);
                                        
                                        setTimeout(function(){
                                          window.location.href = url;
                                        },1000);
                                     }else{
                                        alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'activate_back_theme');

?>