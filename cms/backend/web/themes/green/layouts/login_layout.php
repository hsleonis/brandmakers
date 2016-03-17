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

        $this->registerJsFile(Url::base()."/files/alertify.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerCssFile(Url::base()."/css/alertify.core.css", [
            'media' => 'all',
        ], 'css-alertify-core');

        $this->registerCssFile(Url::base()."/css/alertify.bootstrap.css", [
            'media' => 'all',
        ], 'css-alertify-default');
    ?>
    
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body class="login">
    <?php $this->beginBody() ?>
    <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



