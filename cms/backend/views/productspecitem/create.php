<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductSpecItem */

$this->title = 'Create Product Spec Item';
$this->params['breadcrumbs'][] = ['label' => 'Product Spec Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-spec-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
