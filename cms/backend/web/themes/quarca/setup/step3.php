<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'General Settings';

?>

<div class="site-index">


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 box_slide_down" style="margin-top:100px; display:none;">
                <div class="pane" style="float:left;">
                    <h2><span>General Settings</span></h2>

                    <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                        <div class="tags-form">

                            <form id="params_form" name="params-form">
                                <div class="settings-form">
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Site Title</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="host" name="site_title" class="form-control" value="<?= Yii::$app->params['site_title']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Copyright Text</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="Copyright" name="copyright_text" class="form-control" value="<?= Yii::$app->params['copyright_text']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="text1">Admin Email</label>
                                        <div class="col-lg-8">
                                          <input type="text" class="form-control" name="admin_email" placeholder="Email" id="admin_email" value="<?= Yii::$app->params['adminEmail']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="text1">Contact Email</label>
                                        <div class="col-lg-8">
                                          <input type="text" class="form-control" name="contact_email" placeholder="Email" id="contact_email" value="<?= Yii::$app->params['contact_email']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="text1">Facebook</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="facebook" name="facebook" class="form-control" value="<?= Yii::$app->params['facebook']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="text1">Twitter</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="twitter" name="twitter" class="form-control" value="<?= Yii::$app->params['twitter']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4" for="text1">LinkedIn</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="linkedin" name="linkedin" class="form-control" value="<?= Yii::$app->params['linkedin']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="submit" name="submit" next-url="<?php echo Url::toRoute('step4',true); ?>" value="Next" class="btn btn-sm btn-primary pull-right save_params">
                                    </div>
                                </div>
                            </form>

                            
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

                    
                    $('.save_params').on('click', function() { 
                        var form = $('#params_form');
                        var url= $(this).attr('next-url');

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('setup/step3')."',
                            data: form.serialize(),
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     window.location.href = url;
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'save_params');

?>