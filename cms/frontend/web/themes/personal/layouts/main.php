<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title ng-bind-html="page.title"></title>

    <?php $this->head() ?>

    <link media="all" rel="stylesheet" href="<?= Url::base(); ?>/css/style.css">
	
	<link media="all" rel="stylesheet" href="<?= Url::base(); ?>/css/demo.css">

	<link media="all" rel="stylesheet" href="<?= Url::base(); ?>/css/style1.css">


</head>
<body data-ng-app="homes" data-ng-controller="mainController">
<?php $this->beginBody() ?>



    <?php echo $content; ?>

	
	
	<!-- Scripts -->
	<script src="<?= Url::base(); ?>/js/jquery-1.11.2.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/angular.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/angular-route.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/angular-animate.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/ngStorage.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/angular-ui-router.min.js"></script>
	<script src="<?= Url::base(); ?>/angular/app.js"></script>
	<script src="<?= Url::base(); ?>/angular/controllers.js"></script>
	<script src="<?= Url::base(); ?>/angular/router.js"></script>
	<script src="<?= Url::base(); ?>/js/panel.js"></script>
    <script src="<?= Url::base(); ?>/js/script.js"></script>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
