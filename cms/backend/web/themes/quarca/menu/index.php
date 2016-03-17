<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pane">
    <div class="menu-index">

        <p>
            <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php \yii\widgets\Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'title',
                    /*'timestamp',*/

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>

    </div>
</div>