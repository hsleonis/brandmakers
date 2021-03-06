<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">
    <div class="pane">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Product Category', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php \yii\widgets\Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'cat_title',
                    'cat_desc:ntext',
                    'sort_order',
                    //'created_at',
                    'updated_at',
                    //'createUserName',
                    //'updateUserName',
                    // 'created_by',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
