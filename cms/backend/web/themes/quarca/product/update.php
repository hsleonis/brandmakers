<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Update Product: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form_update', [
        'model' => $model, 'ProductCategoryRel'=>$ProductCategoryRel, 'ProductImageRel'=>$ProductImageRel,
        'dataProvider'=>$dataProvider,'model_q'=>$model_q
    ]) ?>

</div>
