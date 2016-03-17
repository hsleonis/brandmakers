<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'post_title',
            'post_desc:ntext',
            'created_at',
            'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'product_id',
            // 'sort_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
