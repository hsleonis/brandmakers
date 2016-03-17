<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Mail */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>

<div class="mail-form">

    <?php $form = ActiveForm::begin([
                'id' => 'mail-form',
                'action' => ['mail/compose'],
                'enableAjaxValidation' => false,
                'enableClientValidation' =>  true,
                
            ]); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="to">To</label>
        <div class="col-sm-10">
            <?= $form->field($model, 'mailto')->textInput(['class'=>'form-control','id'=>'tag1'])->label(false);  ?>
            
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="to">CC</label>
        <div class="col-sm-10">
            <?= $form->field($model, 'cc')->textInput(['class'=>'form-control','id'=>'tag2'])->label(false);  ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="to">BCC</label>
        <div class="col-sm-10">
            <?= $form->field($model, 'bcc')->textInput(['class'=>'form-control','id'=>'tag3'])->label(false);  ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="to">Subject</label>
        <div class="col-sm-10">
            <?= $form->field($model, 'subject')->textInput(['class'=>'form-control'])->label(false);  ?>
        </div>
    </div>

    

    <div class="col-md-12"><?= $form->field($model, 'message')->textarea(['rows' => 6,'id'=>'editor'])->label(false); ?></div>

    <div class="col-md-12">
        <div class="form-group text-right" style="margin-top:15px;">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn_mail','style'=>'float: right']) ?>
            <span class="mail_loader loader"></span>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
    
    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#mail-form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    beforeSend : function( request ){
                                        $('.btn_mail').attr('disabled','disabled');
                                        $('.mail_loader').show();
                                    },
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            
                                            alertify.log('Mail has been sent successfully.', 'success', 5000);
                                            form[0].reset();
                                            $('#tag1').importTags('');
                                            $('#tag2').importTags('');
                                            $('#tag3').importTags('');
                                            CKEDITOR.instances.editor.setData('');
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }

                                        $('.btn_mail').removeAttr('disabled');
                                        $('.mail_loader').hide();
                                    }
                            });
                            
                            return false;
                    })



                    
            );

    ", yii\web\View::POS_END, 'send_mail');

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('.save_draft', 'click', function(event, jqXHR, settings) {
                        
                            var form = $('#mail-form');
                            if(form.find('.has-error').length) {
                                    return false;
                            }

                            values = form.serializeArray();
                            for (index = 0; index < values.length; ++index) {
                                if (values[index].name == 'Mail[message]') {
                                    values[index].value = CKEDITOR.instances.editor.getData('');
                                    break;
                                }
                            }
                            
                            $.ajax({
                                    url: '".Url::toRoute(['/mail/save_draft'])."',
                                    type: 'post',
                                    data: {data:jQuery.param(values)},
                                    beforeSend : function( request ){
                                        $('.btn_mail').attr('disabled','disabled');
                                        $('.mail_loader').show();
                                    },
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            
                                            alertify.log('Draft has been saved successfully.', 'success', 5000);
                                            form[0].reset();
                                            $('#tag1').importTags('');
                                            $('#tag2').importTags('');
                                            $('#tag3').importTags('');
                                            CKEDITOR.instances.editor.setData('');
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }

                                        $('.btn_mail').removeAttr('disabled');
                                        $('.mail_loader').hide();
                                    }
                            });
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'save_draft');

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('.discard_mail', 'click', function(event, jqXHR, settings) {
                        
                            var form = $('#mail-form');
                                form[0].reset();
                                $('#tag1').importTags('');
                                $('#tag2').importTags('');
                                $('#tag3').importTags('');
                                CKEDITOR.instances.editor.setData('');
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'discard');


    $this->registerJs('
            
            CKEDITOR.replace( "editor", {
                 customConfig: "'.Url::base().'/ckeditor/config_mail.js",
            });

    ', yii\web\View::POS_READY, 'ck_editor_post');

    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/form/tags-input/jquery.tagsinput.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

    $this->registerJs('
            
            $("#tag1").tagsInput({
                interactive: true,
                defaultText:"",
                onChange: function(){
                    validateEmail($(this).val(),"tag1");
                }
            });

            $("#tag2").tagsInput({
                interactive: true,
                defaultText:"",
                onChange: function(){
                    validateEmail($(this).val(),"tag2");
                }
            });

            $("#tag3").tagsInput({
                interactive: true,
                defaultText:"",
                onChange: function(){
                    validateEmail($(this).val(),"tag3");
                }
            });

             function validateEmail(email,id) {
                    var res = email.split(",");
                    var flag = ""; 
                    $.each( res, function( key, value ) {
                        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

                        if(emailReg.test( value )){
                            flag = 0;
                        }else{
                            flag = 1;
                            $("#"+id).removeTag(value);
                        }
                    });
                  
                  if(flag==1){return false;}else{return true;}
                }

    ', yii\web\View::POS_READY, 'tags');
?>