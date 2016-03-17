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

<div class="col-md-6">

        <div class="pane equal">
            

            <table class="table no-margin-bottom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Value</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>1</td>
                    <td>ID</td>
                    <td><?= $model->id; ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Page Title</td>
                    <td><?= $model->page_title; ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Page Slug</td>
                    <td><?= $model->page_slug; ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Short Desc</td>
                    <td><?= $model->short_desc; ?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>External Url</td>
                    <td><?= $model->ext_url; ?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Meta Key</td>
                    <td><?= $model->meta_key; ?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Meta Desc</td>
                    <td><?= $model->meta_desc; ?></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Date</td>
                    <td><?= $model->date; ?></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Status</td>
                    <td><?= $model->status; ?></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Created At</td>
                    <td><?= $model->created_at; ?></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Updated At</td>
                    <td><?= $model->updated_at; ?></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Created By</td>
                    <td><?= $model->createUserName; ?></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Updated By</td>
                    <td><?= $model->updateUserName; ?></td>
                </tr>
            </tbody>
            </table>
            
        </div>

</div>

<div class="col-md-6">
        <div class="pane">
            <h2><span>Actions</span></h2>
            <p >
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php /*Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])*/ ?>
            </p>
        </div>
        <div class="pane">
            <h2><span>Page Type</span></h2>

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

        <div class="pane">
            <h2 style="margin-top:20px;"><span>Page Tags</span></h2>

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

<div class="col-md-12">
    <div class="pane equal">
        <h2><span>Page Description</span></h2>
        
        <?= $model->page_desc; ?>
    </div>
</div>


    <div class="col-md-12">
        <div class="pane">
            <h2 style="margin-top:20px;"><span>Page Images</span></h2>
        </div>
    </div>
    
    <?php 
        if(!empty($model->page_image_rel)){

            foreach ($model->page_image_rel as $key => $value) {
    ?>
        <div class="col-md-3">
            <div class="pane equal">
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
        </div>
    <?php 
            }
        }
        
    ?>




<div class="page-view">

    

    

   <!--  <div class="col-md-8">

        <h3 style="margin-top:0;">Page Description</h3>
        <?= $model->page_desc; ?>

    </div> -->

    <!-- 


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

 -->

</div>
