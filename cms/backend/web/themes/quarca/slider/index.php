<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pane">
    <div class="slider-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Slider', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php \yii\widgets\Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'created_by',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>

    </div>
</div>
