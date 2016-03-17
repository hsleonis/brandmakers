<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostImageRelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Image Rels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-image-rel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post Image Rel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'post_id',
            'image',
            'short_title',
            'short_desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
