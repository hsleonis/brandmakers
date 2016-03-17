<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-index">
    <div class="pane" style="float:left; width:100%;">

        <div class="col-md-12">
            <div class="row">
                
                <ul class="comment_list">
                    <li>
                        <div class="col-md-2">
                            <strong>Name</strong>
                        </div>
                        <div class="col-md-2">
                            <strong>Email</strong>
                        </div>
                        <div class="col-md-5">
                            <strong>Comment</strong>
                        </div>
                        <div class="col-md-3">
                            <strong>Actions</strong>
                        </div>
                    </li>

                    <?php
                        if(isset($data)){
                            foreach ($data as $key) {
                                
                    ?>
                        <li id="comment_row_<?= $key->id; ?>" >
                            
                            <div class="col-md-2">
                                <?= $key->name; ?>
                            </div>
                            <div class="col-md-2" style="overflow:hidden;">
                                <?= $key->email; ?>
                            </div>
                            <div class="col-md-5">
                                <?= $key->comment; ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                    echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                                    echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key->id], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;']);
                                    echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $key->id], ['class' => 'btn btn-danger btn-xs archive_btn','style' => 'margin-left:10px;','data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ]]);
                                    echo Html::a('Approve', ['approve', 'id' => $key->id], ['class' => 'btn btn-success btn-xs approve_btn','style' => 'margin-left:10px;',]);
                                ?>
                            </div>
                        </li>

                    <?php 
                            }
                        }
                    ?>

                </ul>


            </div>
        </div>
    </div>
</div>



<?php
    
    $this->registerJs("
                    $(document).delegate('.approve_btn', 'click', function() { 
                        var url = $(this).attr('href');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : url,
                            data: {},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     alertify.log(data.files.msg, 'success', 5000);
                                     $('#comment_row_'+data.files.id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'apprve');

?>