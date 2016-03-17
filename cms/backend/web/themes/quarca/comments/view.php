<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Comments */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-8 row">
    <div class="pane">
        <div class="comments-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>

                <?php
                    if($model->is_approved==0){
                        echo Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-success btn-sm approve_btn']);
                    }else{
                        echo Html::a('Unapprove', ['unapprove', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm unapprove_btn']);
                    }
                ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'email:email',
                    'city',
                    'comment:ntext',
                    'created_at',
                    'updated_at',
                    'is_approved',
                ],
                'options'=>['class'=>'table table-striped no_border_top'],
            ]) ?>

        </div>
    </div>
</div>


<?php
    $this->registerJs("
                    $(document).delegate('.unapprove_btn', 'click', function() { 
                        var url = $(this).attr('href');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : url,
                            data: {},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     //alertify.log(data.files.msg, 'success', 5000);
                                     //$('#comment_row_'+data.files.id).remove();
                                     location.reload();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'unapprove');

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
                                     //alertify.log(data.files.msg, 'success', 5000);
                                     //$('#comment_row_'+data.files.id).remove();
                                     location.reload();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'apprve');
?>