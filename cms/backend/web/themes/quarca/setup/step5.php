<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Backend Theme';

?>

<div class="site-index">


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 box_slide_down" style="margin-top:100px; display:none;">
                <div class="pane" style="float:left; width:100%;">
                    <h2><span>Backend Theme</span></h2>

                    
                    <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                        <div class="tags-form">

                            <?php
                              foreach ($themes_array as $value) {
                                
                            ?>

                              <div class="col-md-4 <?php echo ($value['name']==Yii::$app->params['backend.theme'])?'theme_active':'';  ?>">
                                <div class="setup_theme_box theme_box">
                                  <div class="setup_theme_img">
                                    <img src="<?= $value['image']; ?>">
                                  </div>
                                  <div class="theme_name">
                                    <?= $value['name']; ?>
                                  </div>
                                  <div class="activate">
                                    <a href="<?php echo Url::toRoute('step6',true); ?>" data="<?= $value['name']; ?>">Activate</a>
                                  </div>

                                  <div class="active">
                                    Active
                                  </div>
                                </div>
                              </div>

                            <?php
                              }
                            ?>

                            <div class="col-md-12" style="margin-bottom:10px;">
                                <a href="<?php echo Url::toRoute('step6',true); ?>" class="btn btn-sm btn-primary pull-right next">Next</a>
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
                    
                    $('.activate a').on('click', function() { 
                        var back_theme = $(this).attr('data');
                        var url = $(this).attr('href');

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('setup/activate_front_theme')."',
                            data: {back_theme:back_theme},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                        alertify.log(data.msg, 'success', 5000);

                                        setTimeout(function(){
                                          location.reload();
                                        },1000);

                                     }else{
                                        alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });

                    $('.next').on('click', function() { 

                        var url = $(this).attr('href');
                        window.location.href = url;
                        
                        return false;
                    });
    ", yii\web\View::POS_READY, 'activate_back_theme');

?>