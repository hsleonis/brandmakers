<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">


<div class="col-md-6">
    <div class="pane">
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
                'is_featured',
                'sort_order',
                'title',
                'slug',
                'desc:html',
                'status',
                'createUserName',
                'updateUserName',
                'created_at',
                'updated_at',
            ],
            'options'=>['class'=>'table table-striped no_border_top'],
        ]) ?>
    </div>
</div>
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    
    <div class="col-md-12 row">
        <div class="uploaded_image_wrap_all">
            <?php 
                if(!empty($model->product_image)){
                    foreach ($model->product_image as $value) {
            ?>

                <div class="col-md-3" data-id="<?php echo $value->id; ?>">
                    <div class="pane" style="padding:5px;">
                        <div class="image_cont">
                            <div class="uploaded_image_wrap product_view_image<?php echo $value->id; ?>">
                                <img src="<?php echo Url::base().'/product_uploads/' .$value->image; ?>" alt="<?php echo $value->image; ?>" width="100%">
                            </div>
                            <label class="product_view_label<?php echo $value->id; ?>"><?php echo $value->title?:'...'; ?></label>
                        </div>
                    </div>
                </div>

            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>
