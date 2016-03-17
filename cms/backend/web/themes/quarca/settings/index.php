<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->params['adminEmail'];
//echo Yii::$app->params['supportEmail'];
  
?>
<link href="<?=$this->theme->baseUrl;?>/vendor/plugins/form/icheck/skins/square/_all.css" rel="stylesheet">

<div class="col-md-12">

      <ul role="tablist" class="nav nav-tabs">
          <li role="presentation" class="active"><a data-toggle="tab" role="tab" aria-controls="home" href="#home" aria-expanded="false">General Settings</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile" aria-expanded="true">Backend Themes</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#front_theme" aria-expanded="true">Frontend Themes</a></li>
       </ul>

      <div class="tab-content">

          <div id="home" class="tab-pane active" role="tabpanel">
            <div class="row">

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Mail Settings</span></h2>

                      <div class="form-group">
                          <label>Admin Email</label>
                          <input type="text" class="form-control" placeholder="Email" id="admin_email" value="<?= Yii::$app->params['adminEmail']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Contact Email</label>
                          <input type="text" class="form-control" placeholder="Email" id="contact_email" value="<?= Yii::$app->params['contact_email']; ?>">
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Header Settings</span></h2>

                      <div class="form-group">
                          <label>Site Title</label>
                          <textarea id="site_title" class="form-control"  maxlength="140"><?= Yii::$app->params['site_title']; ?> </textarea>
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Footer Settings</span></h2>

                      <div class="form-group">
                          <label>Copyright Text</label>
                          <textarea id="copyright_text" class="form-control"  maxlength="140"><?= Yii::$app->params['copyright_text']; ?> </textarea>
                      </div>

                    </div>
              </div>


              <div style="clear:both;"></div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Social Settings</span></h2>

                      <div class="form-group">
                          <label>Facebook</label>
                          <input type="text" id="facebook" class="form-control" value="<?= Yii::$app->params['facebook']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Twitter</label>
                          <input type="text" id="twitter" class="form-control" value="<?= Yii::$app->params['twitter']; ?>">
                      </div>

                      <div class="form-group">
                          <label>LinkedIn</label>
                          <input type="text" id="linkedin" class="form-control" value="<?= Yii::$app->params['linkedin']; ?>">
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                <div class="pane equal">
                  <h2><span>Editor Config</span></h2>

                    <?php 
                      foreach ($configs as $key => $value) {
                    ?>
                          
                          <div class="radio blue">
                              <label>
                                <input type="radio" id="editor" name="editor" value="<?= $value; ?>" <?php  if(Yii::$app->params['editor']==$value){echo 'checked';} ?> > <?php echo ucfirst($value); ?>
                              </label>
                          </div>

                    <?php
                      }
                    ?>
                    
                </div>
              </div>

              <div class="col-md-4">
                      <div class="form-group">
                          <div class="col-lg-8" style="margin:10px 0;">
                            <input type="button" class="btn btn-sm btn-primary save_settings_btn" value="Save Settings">
                          </div>
                      </div>
              </div>



            </div>
          </div>



          <div id="profile" class="tab-pane" role="tabpanel">
                <div class="row">
                  
                  <?php
                    foreach ($themes_array as $value) {
                      
                  ?>

                    <div class="col-md-4 <?php echo ($value['name']==Yii::$app->params['backend.theme'])?'theme_active':'';  ?>">
                      <div class="pane equal">
                        <div class="theme_box">
                          <div class="theme_img">
                            <img src="<?= $value['image']; ?>">
                          </div>
                          <div class="theme_name">
                            <?= $value['name']; ?>
                          </div>
                          <div class="activate">
                            <a href="#" type="back" data="<?= $value['name']; ?>">Activate</a>
                          </div>

                          <div class="active">
                            Active
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                    }
                  ?>

                </div>
          </div>



          <div id="front_theme" class="tab-pane" role="tabpanel">
                <div class="row">
                  
                  <?php
                    foreach ($themes_array_front as $value) {
                      
                  ?>

                    <div class="col-md-4 <?php echo ($value['name']==Yii::$app->params['frontend.theme'])?'theme_active':'';  ?>">
                      <div class="pane equal">
                        <div class="theme_box">
                          <div class="theme_img">
                            <img src="<?= $value['image']; ?>">
                          </div>
                          <div class="theme_name">
                            <?= $value['name']; ?>
                          </div>
                          <div class="activate">
                            <a href="#" type="front" data="<?= $value['name']; ?>">Activate</a>
                          </div>

                          <div class="active">
                            Active
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                    }
                  ?>

                </div>
          </div>

      </div>
</div>

<div class="settings-index">

</div>

<?php
  $this->registerJs("
                    $(document).delegate('.activate a', 'click', function() { 
                        var name = $(this).attr('data');
                        var type = $(this).attr('type');

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('settings/activate_theme')."',
                            data: {name:name,type:type,_csrf: yii.getCsrfToken()},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                      //location.reload();
                                     }else{
                                      alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'activate_theme');


  $this->registerJs("
                    $(document).delegate('.save_settings_btn', 'click', function() { 
                        var admin_email = $('#admin_email').val();
                        var contact_email = $('#contact_email').val();
                        var copyright_text = $('#copyright_text').val();
                        var site_title = $('#site_title').val();
                        var facebook = $('#facebook').val();
                        var twitter = $('#twitter').val();
                        var linkedin = $('#linkedin').val();
                        var editor = $('.checked input[name=editor]').val();

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('settings/save_settings')."',
                            data: {admin_email:admin_email,contact_email:contact_email,copyright_text:copyright_text,site_title:site_title,facebook:facebook,twitter:twitter,linkedin:linkedin,editor:editor},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                      location.reload();
                                     }else{
                                      alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'save_settings_btn');


    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/form/icheck/icheck.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerJs("
                    $('.blue input').iCheck({
                          radioClass: 'iradio_square-blue',
                      });
    ", yii\web\View::POS_READY, 'register_radios');
?>
