<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadUI;
use newerton\jcrop\jCrop;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->page_title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];


$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::base()."/files/custom_test.js", ['depends' => [\yii\web\JqueryAsset::className()]]);



?>



<div class="page-view">

    <p style="text-align:right;">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="col-md-4">
        <div class="row">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'page_title',
                    'page_slug',
                    'short_desc',
                    'meta_key',
                    'meta_desc',
                    'date',
                    'status',
                    'created_at',
                    'updated_at',
                    ['attribute'=>'createUserName', 'format'=>'raw'],
                    ['attribute'=>'updateUserName', 'format'=>'raw'],
                ],
            ]) ?>
        </div>
    </div>

    <div class="col-md-8">

        <h3 style="margin-top:0;">Page Description</h3>
        <?= $model->page_desc; ?>

    </div>

    <div class="col-md-12 page_type_show"> 
        <div class="row">
            <div class="col-md-1"><div class="row"><strong>Page Types:</strong></div></div>
            <div class="col-md-11">
                <?php 
                    if(!empty($model->page_type_rel)){
                        $i=0;
                        foreach ($model->page_type_rel as $key => $value) {
                            if ($i==0){
                                echo '<span class="label label-default">'.$value->page_type.'</span>';
                            }else{
                                echo ', <span class="label label-default">'.$value->page_type.'</span>';
                            }
                            $i++;
                        }
                    }
                    
                ?>
            </div>
            
        </div>
    </div>

    <div class="col-md-12 page_type_show" style="margin-top:10px;"> 
        <div class="row">
            <div class="col-md-1"><div class="row"><strong>Page Tags:</strong></div></div>
            <div class="col-md-11">
                <?php 
                    if(!empty($model->tags)){
                        $i=0;
                        foreach ($model->tags as $key => $value) {
                            if ($i==0){
                                echo '<span class="label label-default">'.$value->name.'</span>';
                            }else{
                                echo ', <span class="label label-default">'.$value->name.'</span>';
                            }
                            $i++;
                        }
                    }
                    
                ?>
            </div>
            
        </div>
    </div>

    <div class="col-md-12"> 
        <div class="row">
            <h4>Page Images</h4>
            <div class="row">

                <?php 
                    if(!empty($model->page_image_rel)){

                        foreach ($model->page_image_rel as $key => $value) {
                ?>
                    <div class="col-md-3" style="margin-bottom:15px;">
                        <div class="image_cont">

                            <div class="uploaded_image_wrap">
                                <img src="<?php echo Url::base().'/uploads/' .$value->image; ?>" alt="<?php echo $value->image; ?>" width="100%">
                            </div>
                            <label>Short Title</label>
                            <p>sfsf</p>
                            <label>Short Description</label>
                            <p>sdfdf</p>

                        </div>
                    </div>
                <?php 
                        }
                    }
                    
                ?>
            </div>
        </div>
    </div>



</div>
