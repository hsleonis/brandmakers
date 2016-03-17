<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSpecificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Specifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-specification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Specification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'item_name',
            'item_val',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
