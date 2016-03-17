<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductSpecification */

$this->title = 'Create Product Specification';
$this->params['breadcrumbs'][] = ['label' => 'Product Specifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-specification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
