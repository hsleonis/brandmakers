<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductPost */

$this->title = 'Create Product Post';
$this->params['breadcrumbs'][] = ['label' => 'Product Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
