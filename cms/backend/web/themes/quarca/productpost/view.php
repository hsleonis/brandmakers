<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductPost */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-post-view">

    <div class="col-md-12">

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
                        <td>Post Title</td>
                        <td><?= $model->post_title; ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Created At</td>
                        <td><?= $model->created_at; ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Updated At</td>
                        <td><?= $model->updated_at; ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Created By</td>
                        <td><?= $model->createUserName; ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Updated By</td>
                        <td><?= $model->updateUserName; ?></td>
                    </tr>
                </tbody>
            </table>
            
        </div>


        <div class="pane"><?= $model->post_desc; ?></div>

    </div>


    <!-- <div class="uploaded_image_wrap_all">
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
    </div> -->

</div>
