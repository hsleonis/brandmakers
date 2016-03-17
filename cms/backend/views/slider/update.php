<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

$this->title = 'Update Slider: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slider-update">


    <?= $this->render('_form_update', [
        'model' => $model, 'SliderImage_model'=>$SliderImage_model, 'images'=>$images
    ]) ?>

</div>
