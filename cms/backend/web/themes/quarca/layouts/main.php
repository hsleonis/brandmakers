<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use backend\models\Comments;
use backend\models\Mail;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
      <meta charset="<?= Yii::$app->charset ?>"/>
      <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <?= Html::csrfMetaTags(); ?>
      
      <title><?= Html::encode($this->title) ?></title>

      <?php $this->head() ?>
      <?php 
          $this->registerJsFile(Url::base()."/files/alertify.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
          $this->registerCssFile(Url::base()."/css/alertify.core.css", [
              'media' => 'all',
          ], 'css-alertify-core');

          $this->registerCssFile(Url::base()."/css/alertify.bootstrap.css", [
              'media' => 'all',
          ], 'css-alertify-default');




      ?>

      <?php
        $this->registerJsFile($this->theme->baseUrl."/vendor/js/required.min.all.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/quarca.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

      ?>
  
      <!-- Styling -->
      <link href="<?php echo $this->theme->baseUrl; ?>/vendor/bootstrap/bootstrap.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/style.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/dashboard-new.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/ui.css" rel="stylesheet">
      
      <!-- Theme -->
      <link id="theme" href="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-default.css" rel="stylesheet" type="text/css">
      
      <!-- Fonts -->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
      <link href="<?php echo $this->theme->baseUrl; ?>/vendor/fonts/font-awesome.min.css" rel="stylesheet">

</head>
    
<body>

  <div id="preloader"><div id="status">&nbsp;</div></div>
  
  <div class="wrapper dashboard">
  <!-- THEME OPTIONS -->
      <div class="theme-options affix">
        <div class="button-switch style"><i class="fa fa-cog fa-2x"></i></div>
        
        <h5>Sidebar Left/Right<br><small>Click on icon to toggle</small></h5>
        <div class="theme-layouts">
            <a class="theme-option-toggle-sidebar">Sidebar Switch</a>
        </div><!-- theme-layouts -->
        
        <div class="divider"></div>
        
        <h5>Available Themes<br><small>9 themes available</small></h5>
        <ul id="theme-switcher" class="theme-switcher">
            <li class="default-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-default.css">&nbsp;</a></li>
            <li class="dark-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-dark.css">&nbsp;</a></li>
            <li class="red-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-red.css">&nbsp;</a></li>
            <li class="yellow-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-yellow.css">&nbsp;</a></li>
            <li class="green-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-green.css">&nbsp;</a></li>
            <li class="blue-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-blue.css">&nbsp;</a></li>
            <li class="purple-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-purple.css">&nbsp;</a></li>
            <li class="pink-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-pink.css">&nbsp;</a></li>
            <li class="orange-theme"><a href="#" id="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-orange.css">&nbsp;</a></li>
        </ul>
      </div><!-- theme-options -->
      
  <!-- HEADER -->
      <header class="header affix" role="banner">
        <nav class="header-navbar">
            <div class="navbar-header clearfix">
                <a class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mini-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-plus"></i>
                </a>
                
                <a class="logo pull-left" href="<?= Url::toRoute(['/site/index']); ?>">
                    <?= Yii::$app->params['site_title']; ?>
                </a>
                
                <a class="sidebar-switch pull-right"><span class="icon fa"></span></a>
            </div>
        
            <div class="collapse navbar-collapse" id="mini-navbar-collapse">
                <form id="top_search" method="post" action="<?= Url::toRoute(['/site/search']); ?>" class="navbar-form navbar-left">
                  <div class="input-group input-group-sm">
                    <input type="text" name="term" class="form-control search_term" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span> 
                  </div>
                </form><!-- /.main-search -->

          
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= Url::toRoute(['/mail/index']); ?>">
                        <i class="fa fa-paper-plane-o"></i>
                        <span>Mail</span>
                    </a></li>
                    <li><a href="<?= Url::toRoute(['/site/timeline']); ?>">
                        <i class="fa fa-paper-plane-o"></i>
                        <span>Timeline</span>
                    </a></li>
                    <li><a href="<?= Url::toRoute(['/settings/index']); ?>">
                        <i class="fa fa-wrench"></i>
                        <span>Settings</span>
                    </a></li>
                    <li><a href="#" class="lock_screen_btn">
                        <i class="fa fa-lock"></i>
                        <span>Lock</span>
                    </a></li>
                    <li class="turn-off"><a href="<?= Url::toRoute(['/site/logout']); ?>" data-method="post">
                        <i class="fa fa-power-off"></i>
                        <span>Log Out</span>
                    </a></li>
                </ul>
            </div><!-- navbar-collapse -->
        </nav>
      </header>
  <!-- HEADER -->

  <!-- SIDEBAR -->
  <aside class="sidebar affix" role="complementary">
    
    <div class="sidebar-container">
        <div class="sidebar-scrollpane">
          <div class="sidebar-content">
              
              <div class="sidebar-profile clearfix">
                  <a href="#" class="pull-left">
                      <figure class="profile-picture">
                          <img src="<?php echo Url::base(); ?>/user_img/<?php echo \Yii::$app->session->get('user.image'); ?>" alt="User Picture">
                      </figure>
                  </a>
                  <h6>Welcome,</h6>
                  <h5><?= \Yii::$app->session->get('user.username');  ?></h5>
                  <div class="btn-group">
                      <a data-toggle="dropdown">
                        <span>
                            Last Access: <span class="online"><?= date_format(date_create(\Yii::$app->session->get('user.last_access')), "F j, Y, g:i a"); ?></span>
                        </span>
                      </a>
                      <ul class="dropdown-menu default" role="menu">
                        <li><a data-status="online"><span class="label label-status label-online">&nbsp;</span> Online</a></li>
                        <li><a data-status="busy"><span class="label label-status label-busy">&nbsp;</span> Busy</a></li>
                        <li><a data-status="away"><span class="label label-status label-away">&nbsp;</span> Away</a></li>
                        <li><a data-status="offline"><span class="label label-status label-offline">&nbsp;</span> Offline</a></li>
                      </ul>
                  </div>
              </div><!-- sidebar-profile -->
              
              <div role="tabpanel">
            <!-- Nav tabs -->
                  <ul class="tab-nav" role="tablist">
                      <li role="presentation" class="active">
                        <a href="#nav" aria-controls="nav" role="tab" data-toggle="tab">
                            <i class="fa fa-navicon"></i>
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#emails" aria-controls="emails" role="tab" data-toggle="tab">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge">6</span>
                        </a>
                      </li>
                      <li role="presentation">
                        <a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge">

                            <?php
                              $comment_count = Comments::find()->where(['is_approved'=>0])->count();
                              echo $comment_count;
                            ?>

                            </span>
                        </a>
                      </li>
                  </ul><!-- nav -->
            
            <!-- Tab panes -->
                  <div class="tab-content">
                      
                      <div role="tabpanel" class="tab-pane fade in active" id="nav">
                        <h4>Navigation</h4>
                        <nav class="main-nav">
                            <ul id="sidebar-nav" class="sidebar-nav">
                              <li class="<?php echo (Yii::$app->controller->id=='site')?'active':''; ?>">
                                  <a href="<?= Url::toRoute(['/site/index']); ?>">
                                    <i class="fa fa-tachometer fa-fw fa-lg"></i> Dashboard &nbsp;<span class="label label-success">New</span>
                                  </a>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='page')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-leanpub fa-fw fa-lg"></i> Page Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/page/list']); ?>">Page List</a></li>
                                    <li><a href="<?= Url::toRoute(['/page/create']); ?>">Create Page</a></li>
                                    <li><a href="<?= Url::toRoute(['/page/archive_list']); ?>">Archived Pages</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='user' || Yii::$app->controller->id=='admin')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-user-plus fa-fw fa-lg"></i> User Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/user/index']); ?>">User List</a></li>
                                    <li><a href="<?= Url::toRoute(['/user/create']); ?>">Create User</a></li>
                                    <li><a href="<?= Url::toRoute(['/admin/route']); ?>">Manage Route Access</a></li>
                                    <li><a href="<?= Url::toRoute(['/admin/role']); ?>">Manage User Role</a></li>
                                    <li><a href="<?= Url::toRoute(['/admin/assignment']); ?>">Manage User Assignment</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='menu')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-bars fa-fw fa-lg"></i> Menu Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/menu/index']); ?>">Menu List</a></li>
                                    <li><a href="<?= Url::toRoute(['/menu/create']); ?>">Create Menu</a></li>
                                    <li><a href="<?= Url::toRoute(['/menu/menu_items']); ?>">Edit Menu</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='productcategory')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-table fa-fw fa-lg"></i> Product Category Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/productcategory/index']); ?>">Manage Product Category</a></li>
                                    <li><a href="<?= Url::toRoute(['/productcategory/create']); ?>">Create Product Category</a></li>
                                    <li><a href="<?= Url::toRoute(['/productcategory/category_list']); ?>">Product Category list</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='product' || Yii::$app->controller->id=='productspecitem')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-shopping-cart fa-fw fa-lg"></i> Product Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/product/index']); ?>">Manage Product</a></li>
                                    <li><a href="<?= Url::toRoute(['/product/create']); ?>">Create Product</a></li>
                                    <li><a href="<?= Url::toRoute(['/productspecitem/index']); ?>">Manage Product Specification Item</a></li>
                                    <li><a href="<?= Url::toRoute(['/productspecitem/create']); ?>">Create Product Specification Item</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='tags')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-tags fa-fw fa-lg"></i> Tag Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/tags/index']); ?>">Manage Tags</a></li>
                                    <li><a href="<?= Url::toRoute(['/tags/create']); ?>">Create Tag</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='slider')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-picture-o fa-fw fa-lg"></i> Slider Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/slider/index']); ?>">Manage Slider</a></li>
                                    <li><a href="<?= Url::toRoute(['/slider/create']); ?>">Create Slider</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='comments')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-picture-o fa-fw fa-lg"></i> Comments Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/comments/index']); ?>">Unapproved Comments</a></li>
                                    <li><a href="<?= Url::toRoute(['/comments/approved_comments']); ?>">Approved Comments</a></li>
                                  </ul>
                              </li>

                              <li class="<?php echo (Yii::$app->controller->id=='news')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-newspaper-o"></i> News Module
                                  </a>
                                  <ul class="collapse">
                                    <li><a href="<?= Url::toRoute(['/news/index']); ?>">Manage News</a></li>
                                    <li><a href="<?= Url::toRoute(['/news/create']); ?>">Create News</a></li>
                                  </ul>
                              </li>
                          
                          
                          
                            </ul><!-- sidebar-nav -->
                        </nav>
                    
                    
                      </div><!-- tab-pane -->
                      
                      <div role="tabpanel" class="tab-pane fade" id="emails">
                          <h4>Emails</h4>
                          <div class="sidebar-emails-container" role="tabpanel">
                          
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
                                <li role="presentation"><a href="#sent" aria-controls="sent" role="tab" data-toggle="tab">Sent</a></li>
                              </ul><!-- nav-tabs -->
                          
                              <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade in active" id="inbox">
                                      <ul class="emails-list">
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb">
                                            J
                                              </div>
                                              <div class="email-short">
                                            <h6>Jennifer Meza</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">21/01/15</span>
                                          </a></li>
                                          
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb">
                                            A
                                              </div>
                                              <div class="email-short">
                                            <h6>Arthur Hernandez</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">20/01/15</span>
                                          </a></li>
                                          
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb image">
                                            
                                              </div>
                                              <div class="email-short">
                                            <h6>Alicia Garcia</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">18/01/15</span>
                                          </a></li>
                                          
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb">
                                            S
                                              </div>
                                              <div class="email-short">
                                            <h6>someone@gmail.com</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">17/01/15</span>
                                          </a></li>
                                          
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb image">
                                            <img src="<?php echo $this->theme->baseUrl; ?>/assets/img/uploads/profile2.jpg" class="img-circle" alt="Profile Pic">
                                              </div>
                                              <div class="email-short">
                                            <h6>Michelle Bowman</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">14/01/15</span>
                                          </a></li>
                                          
                                          <li><a href="#" class="clearfix">
                                              <div class="email-thumb image">
                                            <img src="<?php echo $this->theme->baseUrl; ?>/assets/img/uploads/profile3.jpg" class="img-circle" alt="Profile Pic">
                                              </div>
                                              <div class="email-short">
                                            <h6>Jimmy Simmons</h6>
                                            <small>Lorem ipsum dolor sit amet...</small>
                                              </div>
                                              <span class="when">13/01/15</span>
                                          </a></li>
                                      </ul><!-- emails-list -->
                                  </div><!-- tab-pane -->
                            
                                  <div role="tabpanel" class="tab-pane fade" id="sent">
                                      <ul class="emails-list">
                                        <li><a href="#" class="clearfix">
                                            <div class="email-thumb">
                                          J
                                            </div>
                                            <div class="email-short">
                                          <h6>Jennifer Meza</h6>
                                          <small>Lorem ipsum dolor sit amet...</small>
                                            </div>
                                            <span class="when">21/01/15</span>
                                        </a></li>
                                      </ul><!-- emails-list -->
                                  </div><!-- tab-pane -->
                              </div><!-- tab-content -->
                          
                          </div><!-- sidebar-emails-container -->
                      </div><!-- tab-pane -->
                      
                      <div role="tabpanel" class="tab-pane fade" id="notifications">
                          
                          <h4>Unapproved Comments</h4>
                          <ul class="emails-list">

                          <?php
                            $data = Comments::find()->where(['is_approved'=>0])->all();
                            $count = count($data);

                            foreach ($data as $key) {
                              
                          ?>
                              <li>
                                <a href="<?= Url::toRoute(['/comments/view','id'=>$key->id]); ?>" class="clearfix">
                                  <div class="email-thumb">
                                    <?php echo $key->name[0]; ?>
                                  </div>
                                  <div class="email-short">
                                    <h6><?= $key->name; ?></h6>
                                    <small><?= Mail::limit_str(35,strip_tags($key->comment)); ?></small>
                                  </div>
                                  <span class="when"><?= date_format(date_create($key->updated_at), "F j, Y, g:i a"); ?></span>
                                </a>
                              </li>
                          <?php
                            }
                          ?>
                              
                          </ul><!-- notifications -->
                      </div><!-- tab-pane -->
                      
                  </div><!-- tab-content -->
              </div><!-- tabpanel -->
              
          </div><!-- sidebar-content -->
        </div><!-- scrollpane -->
    </div><!-- sidebar-container -->
    
  </aside><!-- sidebar -->
      
      
  <!-- MAIN -->
      <div class="main">
      <!-- CONTENT -->
    <div id="content">
        <div class="page-title">
          <h1><?= Html::encode($this->title) ?></h1>
          <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
        </div>
        <div class="container-fluid">

            <?= $content ?>

        </div><!-- container-fluid -->
        
    </div><!-- content -->
      <!-- CONTENT -->
    
      <!-- FOOTER -->
    <footer id="footer" role="contentinfo">
        <?= Yii::$app->params['copyright_text']; ?>
    </footer>
      <!-- FOOTER -->
      </div><!-- main -->
  <!-- /MAIN  -->
  </div><!-- wrapper -->
  
 

    <?php $this->endBody() ?>
    </body>



<!-- Mirrored from cazylabs.com/themes-demo/quarca/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Apr 2015 20:06:23 GMT -->
</html>
<?php

        $this->registerJs("
                        
        $( '#top_search' ).submit(function( event ) {
            var form = $(this);
            if(form.find('.search_term').val()=='') {
              $('.search_term').focus();
                    return false;
            }
            
            $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    beforeSend : function( request ){
                      $('#myModal_search .modal-body').html('');
                      $('#myModal_search .modal-body').addClass('loader');
                      $('#myModal_search').modal('show');
                    },
                    success: function(data) {
                      dt = jQuery.parseJSON(data);

                      $('#myModal_search .modal-body').removeClass('loader');
                      $('#myModal_search .modal-body').html(dt.view);
                        
                    }
            });
            event.preventDefault();
        });

        ", yii\web\View::POS_READY, 'search_all');


        $this->registerJs("
                        
        var idleTime = 0;
        $(document).ready(function () {
            //Increment the idle time counter every minute.
            var idleInterval = setInterval(timerIncrement, 1000); // 1 sec

            //Zero the idle timer on mouse movement.
            $(this).mousemove(function (e) {
                idleTime = 0;
            });
            $(this).keypress(function (e) {
                idleTime = 0;
            });
        });

        function timerIncrement() {
            idleTime = idleTime + 1;
            if (idleTime > 60000000000) { // 10 min
                window.location.href = '".\yii\helpers\Url::toRoute(['/site/lock_screen'])."?previous='+encodeURIComponent(window.location.href);
                idleTime = 0;
            }
        }

        $('.lock_screen_btn').on('click',function(){
            window.location.href = '".\yii\helpers\Url::toRoute(['/site/lock_screen'])."?previous='+encodeURIComponent(window.location.href);
        });

        ", yii\web\View::POS_READY, 'lock');

    ?>
<?php $this->endPage() ?>

  

  
  <!-- Init -->
  

<!-- Modal -->
    <div class="modal full fade" id="myModal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Search Results</h4>
          </div>
          <div class="modal-body">
                    
          </div>
          
        </div>
      </div>
    </div>

<script type="text/javascript">

    $(document).delegate('.full-box-modal', 'click', function() { 

        if($(this).hasClass('open')){
            $(document).fullScreen(false);

            $(this).removeClass('open');

            $(this).parents('.modal-dialog').css('position','unset');
            $(this).parents('.modal-dialog').css('width','900px');
            $(this).parents('.modal-dialog').css('height','auto');
            $(this).parents('.modal-dialog').css('margin','30px auto');
            $(this).parents('.modal-body').css('max-height', '550px');
            $(this).parents('.modal-content').css('height', 'auto');
        }else{
            $(document).fullScreen(true);

          $(this).addClass('open')

          $(this).parents('.modal-dialog').css('position','fixed');
          $(this).parents('.modal-dialog').css('width','100%');
          $(this).parents('.modal-dialog').css('height',$(document).height()+'px');
          $(this).parents('.modal-dialog').css('margin','0px auto');
          $(this).parents('.modal-body').css('max-height',$(document).height()+'px');
          $(this).parents('.modal-content').css('height',$(document).height()+'px');
        }
        
    });
    
</script>