<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <?php
        $this->registerCssFile(Url::base()."/css/main.css");
    ?>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

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

        $this->registerJsFile(Url::base()."/js/bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile(Url::base()."/files/jquery.fullscreen-min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
    <style type="text/css">
      .navbar-inverse {
          background-color: green;
          border-color: #080808;
      }
    </style>

</head>
<body class="sidebar-left-mini">
    <?php $this->beginBody() ?>
    <div id="wrap" class="bg-dark dk">

        <div id="top">
            

            <nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <header class="navbar-header">
                  <button data-target=".navbar-ex1-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="sr-only">Toggle navigation</span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                  </button>
                  <a class="navbar-brand" href="index.html">
                    Advance
                  </a> 
                </header>
                <div class="topnav">

                  <div class="search-bar">
                    <form id="top_search" method="post" action="<?= Url::toRoute(['/site/search']); ?>" class="main-search">
                      <div class="input-group">
                        <input type="text" name="term" placeholder="Live Search ..." class="form-control search_term">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm text-muted" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span> 
                      </div>
                    </form><!-- /.main-search -->
                  </div><!-- /.search-bar -->


                  <div class="btn-group">
                    <a id="toggleFullScreen" class="btn btn-default btn-sm fullscreen_btn" onclick="$(document).toggleFullScreen();" data-toggle="tooltip" data-original-title="Fullscreen" data-placement="bottom">
                      <i class="glyphicon glyphicon-fullscreen"></i>
                    </a> 
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-sm" data-toggle="tooltip" data-original-title="E-mail" data-placement="bottom">
                      <i class="fa fa-envelope"></i>
                      <span class="label label-warning">5</span> 
                    </a> 
                    <a class="btn btn-default btn-sm" data-toggle="tooltip" href="#" data-original-title="Messages" data-placement="bottom">
                      <i class="fa fa-comments"></i>
                      <span class="label label-danger">4</span> 
                    </a> 
                    <a href="#helpModal" class="btn btn-default btn-sm" data-placement="bottom" data-original-title="Help" data-toggle="modal">
                      <i class="fa fa-question"></i>
                    </a> 
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-metis-1 btn-sm" data-placement="bottom" data-original-title="Logout" data-toggle="tooltip" href="<?php echo \yii\helpers\Url::toRoute(['/site/logout']); ?>" data-method="post">
                      <i class="fa fa-power-off"></i>
                    </a> 
                  </div>
                  <div class="btn-group">
                    <a id="menu-toggle" class="btn btn-primary btn-sm toggle-left" data-toggle="tooltip" data-original-title="Show / Hide Left" data-placement="bottom">
                      <i class="fa fa-bars"></i>
                    </a> 
                    <a class="btn btn-default btn-sm toggle-right" data-toggle="tooltip" data-original-title="Show / Hide Right" data-placement="bottom"> <span class="glyphicon glyphicon-comment"></span>  </a> 
                  </div>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">

                  <!-- .nav -->
                  <ul class="nav navbar-nav">
                    <li> <a href="<?= Url::toRoute(['/site/index']); ?>">Dashboard</a>  </li>
                    <li class="dropdown ">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        Manage User Access
                        <b class="caret"></b>
                      </a> 
                      <ul class="dropdown-menu top_sub">
                        <li> <a href="<?php echo \yii\helpers\Url::toRoute(['/admin/route']); ?>" class="btn btn-sm">Manage Route</a>  </li>
                        <li> <a href="<?php echo \yii\helpers\Url::toRoute(['/admin/role']); ?>" class="btn btn-sm">Manage Role</a></li>
                        <li> <a href="<?php echo \yii\helpers\Url::toRoute(['/admin/assignment']); ?>" class="btn btn-sm">Manage User Assignment</a></li>

                      </ul>
                    </li>
                    <li> <a href="<?= Url::toRoute(['/site/timeline']); ?>">Timeline</a>  </li>
                    <li> <a href="<?= Url::toRoute(['/settings/index']); ?>">Settings</a>  </li>
                  </ul><!-- /.nav -->
                </div>
              </div><!-- /.container-fluid -->
            </nav>


            <header class="head">

                  <div class="main-bar">
                    <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                    <h3>
                      <i class="fa fa-building"></i>&nbsp; <?= Html::encode($this->title) ?></h3>
                        
                  </div><!-- /.main-bar -->

            </header>
        </div>

        <div id="left">
        <div class="media user-media bg-dark dker">
          <div class="user-media-toggleHover">
            <span class="fa fa-user"></span> 
          </div>
          <div class="user-wrapper bg-dark">
            <a href="" class="user-link">
              <img src="<?php echo Url::base(); ?>/user_img/<?php echo \Yii::$app->session->get('user.image'); ?>" alt="User Picture" width="100" class="media-object img-thumbnail user-img">
              <span class="label label-danger user-label"></span> 
            </a> 
            <div class="media-body">
              <h5 class="media-heading"><?= \Yii::$app->session->get('user.username');  ?></h5>
              <ul class="list-unstyled user-info">
                <li> <a href="">
                    <?php
                        $user_role = '';
                        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
                        foreach ($roles as $key => $value) {
                            $user_role .= $value->name.', ';
                        }

                        echo $user_role;
                    ?>

                </a>  </li>
                <li>Last Access :
                  <br>
                  <small>
                    <i class="fa fa-calendar"></i>&nbsp;<?= date_format(date_create(\Yii::$app->session->get('user.last_access')), "F j, Y, g:i a"); ?></small> 
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- #menu -->
        <ul class="bg-blue dker" id="menu">
          <li class="nav-header">Menu</li>
          <li class="nav-divider"></li>
          <li class="">
            <a href="<?= Url::toRoute(['/site/index']); ?>">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Dashboard</span> 
            </a> 
          </li>
          <li class="active">
            <a href="javascript:;">
              <i class="fa fa-leanpub"></i>
              <span class="link-title">Pages</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse in">
              
              <li>
                <a href="<?= Url::toRoute(['/page/list']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Page List </a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/page/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create Page </a> 
              </li>
              
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <i class="fa fa-user-plus"></i>
              <span class="link-title">User</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse">
                <li>
                <a href="<?= Url::toRoute(['/user/index']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; User List</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/user/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create User </a> 
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <i class="fa fa-bars"></i>
              <span class="link-title">Menu</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse">
              <li>
                <a href="<?= Url::toRoute(['/menu/index']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Menu List</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/menu/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create Menu </a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/menu/menu_items']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Edit Menu </a> 
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <i class="fa fa-table"></i>
              <span class="link-title">Product Category</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse">
              <li>
                <a href="<?= Url::toRoute(['/productcategory/index']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Manage Product Category</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/productcategory/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create Product Category</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/productcategory/category_list']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Product Category list</a> 
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
              <span class="link-title">Product</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse">
              <li>
                <a href="<?= Url::toRoute(['/product/index']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Manage Product</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/product/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create Product</a> 
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
              <span class="link-title">Tags</span> 
              <span class="fa arrow"></span> 
            </a> 
            <ul class="collapse">
              <li>
                <a href="<?= Url::toRoute(['/tags/index']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Manage Tags</a> 
              </li>
              <li>
                <a href="<?= Url::toRoute(['/tags/create']); ?>">
                  <i class="fa fa-angle-right"></i>&nbsp; Create Tags</a> 
              </li>
            </ul>
          </li>
        </ul><!-- /#menu -->
      </div>

        

        <div id="content">
              <div class="inner bg-light lter">
                    <?= $content ?>
              </div><!-- /.inner -->
        </div>

    </div>

    <footer class="Footer bg-dark dker">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>


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

?>

    <?php $this->endBody() ?>
</body>
</html>

    


<?php $this->endPage() ?>
<!-- Modal -->
    <div class="modal fade" id="myModal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    $('#content > .inner').css('min-height',$(window).height()-158+'px');
    $(window).resize(function(){
      $('#content > .inner').css('min-height',$(window).height()-158+'px');
    });


    /*$(document).delegate('.full-box', 'click', function() { 
        $(this).parents('.full-screen-box').toggleFullScreen();
    });*/


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

<script type="text/javascript">
  $(document).ready(function(){
    $('.fullscreen_btn').click();
  });
  
</script>