<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PostImageRel */

$this->title = 'Create Post Image Rel';
$this->params['breadcrumbs'][] = ['label' => 'Post Image Rels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-image-rel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
