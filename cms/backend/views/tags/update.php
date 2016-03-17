<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tags */

$this->title = 'Update Tags: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tags-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
