<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */

$this->title = $model->cat_title;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-6 row">
    <div class="pane">
        <div class="product-category-view">

            <!-- <h1><?= Html::encode($this->title) ?></h1> -->

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'cat_title',
                    'cat_slug',
                    'cat_desc:ntext',
                    'created_at',
                    'updated_at',
                    'createUserName',
                    'updateUserName',
                ],
                'options'=>['class'=>'table table-striped no_border_top'],
            ]) ?>

        </div>
    </div>
</div>