<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->params['adminEmail'];
//echo Yii::$app->params['supportEmail'];
  
?>

    <ul role="tablist" class="nav nav-tabs">
        <li role="presentation" class="active"><a data-toggle="tab" role="tab" aria-controls="home" href="#home" aria-expanded="false">General Settings</a></li>
        <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile" aria-expanded="true">Backend Themes</a></li>
        <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#front_theme" aria-expanded="true">Frontend Themes</a></li>
     </ul>

    <div class="tab-content">

        <div id="home" class="tab-pane active" role="tabpanel">
          <div class="row">

            <div class="col-md-4">
                
                    <div class="box dark full-screen-box">
                        <header>
                            <div class="icons">
                              <i class="fa fa-edit"></i>
                            </div>
                            <h5>Mail Settings</h5>

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

                            <div class="settings-form">

                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Admin Email</label>
                                    <div class="col-lg-8">
                                      <input type="text" class="form-control" placeholder="Email" id="admin_email" value="<?= Yii::$app->params['adminEmail']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Contact Email</label>
                                    <div class="col-lg-8">
                                      <input type="text" class="form-control" placeholder="Email" id="contact_email" value="<?= Yii::$app->params['contact_email']; ?>">
                                    </div>
                                </div>


                            </div>
                            
                        </div>
                    </div>

            </div>

            <div class="col-md-4">
                    <div class="box dark full-screen-box">
                        <header>
                            <div class="icons">
                              <i class="fa fa-edit"></i>
                            </div>
                            <h5>Header Settings</h5>

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

                            <div class="settings-form">

                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Site Title</label>
                                    <div class="col-lg-8">
                                      <textarea id="site_title" class="form-control"  maxlength="140"><?= Yii::$app->params['site_title']; ?> </textarea>
                                    </div>
                                </div>


                            </div>
                            
                         </div>

                    </div>
            </div>

            <div class="col-md-4">
                    <div class="box dark full-screen-box">
                        <header>
                            <div class="icons">
                              <i class="fa fa-edit"></i>
                            </div>
                            <h5>Footer Settings</h5>

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

                            <div class="settings-form">

                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Copyright Text</label>
                                    <div class="col-lg-8">
                                      <textarea id="copyright_text" class="form-control"  maxlength="140"><?= Yii::$app->params['copyright_text']; ?> </textarea>
                                    </div>
                                </div>

                            </div>
                            
                         </div>

                    </div>
            </div>

            <div style="clear:both;"></div>


            <div class="col-md-4">
                    <div class="box dark full-screen-box">
                        <header>
                            <div class="icons">
                              <i class="fa fa-edit"></i>
                            </div>
                            <h5>Social Settings</h5>

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

                            <div class="settings-form">

                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Facebook</label>
                                    <div class="col-lg-8">
                                      <input type="text" id="facebook" class="form-control" value="<?= Yii::$app->params['facebook']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">Twitter</label>
                                    <div class="col-lg-8">
                                      <input type="text" id="twitter" class="form-control" value="<?= Yii::$app->params['twitter']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="text1">LinkedIn</label>
                                    <div class="col-lg-8">
                                      <input type="text" id="linkedin" class="form-control" value="<?= Yii::$app->params['linkedin']; ?>">
                                    </div>
                                </div>



                            </div>
                            
                         </div>

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
            <div class="col-md-12">
              <div class="row">
                
                <?php
                  foreach ($themes_array as $value) {
                    
                ?>

                  <div class="col-md-3 <?php echo ($value['name']==Yii::$app->params['backend.theme'])?'theme_active':'';  ?>">
                    <div class="theme_box">
                      <div class="theme_img">
                        <img src="<?= $value['image']; ?>">
                      </div>
                      <div class="theme_name">
                        <?= $value['name']; ?>
                      </div>
                      <div class="activate">
                        <a href="#"  type="back" data="<?= $value['name']; ?>">Activate</a>
                      </div>

                      <div class="active">
                        Active
                      </div>
                    </div>
                  </div>

                <?php
                  }
                ?>

              </div>
            </div>
        </div>



        <div id="front_theme" class="tab-pane" role="tabpanel">
            <div class="col-md-12">
              <div class="row">
                
                <?php
                  foreach ($themes_array_front as $value) {
                    
                ?>

                  <div class="col-md-3 <?php echo ($value['name']==Yii::$app->params['frontend.theme'])?'theme_active':'';  ?>">
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
                                      location.reload();
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

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('settings/save_settings')."',
                            data: {admin_email:admin_email,contact_email:contact_email,copyright_text:copyright_text,site_title:site_title,facebook:facebook,twitter:twitter,linkedin:linkedin},
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
?>
