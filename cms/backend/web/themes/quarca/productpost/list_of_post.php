<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\ProductPost;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

?>
<div class="post-view">

<ul class="post_sort">

    <?php
        $posts = ProductPost::find()->where(['product_id'=>$product_id])->orderBy('sort_order asc')->all();

        if(!empty($posts)){
          foreach ($posts as $value) {
            echo '<li data-id="'.$value->id.'" class="Post_'.$value->id.'">'; 
                echo '<div class="col-md-8">'.$value->post_title.'</div>';
                echo '<div class="col-md-4">';
                    echo '<input type="button" class="btn btn-sm btn-primary view_post_btn" value="View" data_id="'.$value->id.'">';
                    echo '<input type="button" class="btn btn-sm btn-default update_post_btn" value="Update" data_id="'.$value->id.'" style="margin-left:10px;">';
                    echo '<input type="button" class="btn btn-sm btn-danger delete_post_btn" value="Delete" data_id="'.$value->id.'" style="margin-left:10px;">';
                    echo '<span>'.$value->sort_order.'</span>';
                echo '</div>';
            echo '</li>';
          }
          
        }
    ?>

</div>