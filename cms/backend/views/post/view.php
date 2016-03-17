<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">


    <p style="text-align:right;">
        
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
            'post_title',
            'desc:html',
            'created_at',
            'updated_at',
            'createUserName',
            'updateUserName',
        ],
    ]) ?>

    <div class="uploaded_image_wrap_all">
        <?php 
            if(!empty($model->post_image_rel)){
                foreach ($model->post_image_rel as $key) {
        ?>

            <div class="col-md-3 post_image_<?php echo $key->id; ?>" style="display:inline-block;">
                <div class="image_cont">
                    <div class="uploaded_image_wrap">
                        <img src="<?php echo Url::base().'/post_uploads/'.$key->image; ?>" alt="<?php echo $key->image; ?>" width="100%">
                    </div>
                </div>
            </div>

        <?php
                }
            }
        ?>
    </div>
</div>
