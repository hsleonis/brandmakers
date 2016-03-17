<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Comments */

$this->title = 'Create Comments';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
