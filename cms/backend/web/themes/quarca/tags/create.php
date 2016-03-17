<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tags */

$this->title = 'Create Tags';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
