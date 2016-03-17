<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Post;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

?>
<div class="post-view">

<ul class="post_sort">

    <?php
        $posts = Post::find()->where(['page_id'=>$page_id])->orderBy('sort_order asc')->all();

        if(!empty($posts)){
          foreach ($posts as $value) {
            echo '<li data-id="'.$value->id.'">'; 
                echo '<div class="col-md-8">'.$value->post_title.'</div>';
                echo '<div class="col-md-4">';
                    echo '<input type="button" class="btn btn-sm btn-primary view_post_btn" value="View" data_id="'.$value->id.'">';
                    echo '<input type="button" class="btn btn-sm btn-default update_post_btn" value="Update" data_id="'.$value->id.'" style="margin-left:10px;">';
                    echo '<span>'.$value->sort_order.'</span>';
                echo '</div>';
            echo '</li>';
          }

            /*echo '<table class="table table-striped post_list" style="margin-top:15px;">';
              foreach ($posts as $value) {
                 echo '<tr>';
                    echo '<td>'.$value->post_title.'</td>';
                    echo '<td>';
                        
                    echo '</td>';
                 echo "</tr>";
              }
            echo '</table>';*/
        }
    ?>

</div>
