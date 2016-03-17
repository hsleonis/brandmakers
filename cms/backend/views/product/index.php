<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'created_at',
                'label' => 'Created Time',
                'format' => 'raw',
                'value' => function ($data) {
                                return date_format(date_create($data["created_at"]), "d-m-Y").'&nbsp;&nbsp;&nbsp;'.date_format(date_create($data['created_at']), 'g:i A');
                            },
                'filter'=>''
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Updated Time',
                'format' => 'raw',
                'value' => function ($data) {
                                return date_format(date_create($data["updated_at"]), "d-m-Y").'&nbsp;&nbsp;&nbsp;'.date_format(date_create($data['updated_at']), 'g:i A');
                            },
                'filter'=>''
            ],
            'createUserName',
            'updateUserName',
            //'desc:ntext',
            //'model',
            //'size',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
