<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSpecItem */

$this->title = 'Update Product Spec Item: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Spec Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-spec-item-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
