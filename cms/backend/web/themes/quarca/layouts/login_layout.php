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
    
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body class="page-membership">
    <?php $this->beginBody() ?>
    <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>

<script src="<?php echo $this->theme->baseUrl; ?>/vendor/plugins/others/jquery-cookie/jquery.cookie.js"></script>
    
    <script type="text/javascript">

    $(window).load(function() { // makes sure the whole site is loaded
        $('#status').fadeOut( "slow" ); // will first fade out the loading animation
        $('#preloader').fadeOut( "slow" ); // will fade out the white DIV that covers the website.
        $('body').delay(350).css({'overflow':'visible'});
    })
    
    /*******************************
    THEME COLOR COOKIE
    *******************************/
    if($.cookie("css")) {
        $("#theme").attr("href",$.cookie("css"));
    }
    </script>
<?php $this->endPage() ?>



