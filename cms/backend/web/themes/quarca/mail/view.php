<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Mail */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <div class="col-md-2">
        <div class="">
            <div class="pane" style="background:none; padding:0;">
                <p>
                    <?= Html::a('Compose', ['compose'], ['class' => 'btn btn-success','style'=>'width:100%;']) ?>
                </p>
                <ul class="list-unstyled mailbox-nav">
                    <li class="<?php echo (Yii::$app->controller->action->id=='index')?'active':''; ?>" ><a href="<?= Url::toRoute(['/mail/index']); ?>"><i class="fa fa-inbox"></i>Inbox <span class="badge badge-success pull-right">4</span></a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='sent')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/sent']); ?>"><i class="fa fa-sign-out"></i>Sent</a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='draft')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/draft']); ?>"><i class="fa fa-file-text-o"></i>Draft</a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='trash')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/trash']); ?>"><i class="fa fa-trash"></i>Trash</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-10">
            <div class="pane">
            <h2><span><?=$model->subject;?></span></h2>
            <p class="from_email">
                <strong>From:</strong> 
                <?php 
                    if($model->type == 'inbox'){
                        echo $model->mailfrom;
                    }else{
                        echo \Yii::$app->params['admin_email']; 
                    }
                ?>

                <span class="from_email_time"><?= date_format(date_create($model->create_time), "F j, Y, g:i a"); ?></span>
            </p>
            
            <p>
                <?php
                    echo '<strong>To:</strong> ';
                    if($model->type == 'inbox'){
                        echo \Yii::$app->params['admin_email'];
                    }else{
                        $address = explode(',', $model->mailto);
                        
                        foreach ($address as $key) {
                            echo explode('@', $key)[0].', ';
                        }
                    }
                    
                ?>
            </p>
            <div class="mail_detail">
                <button class="btn dropdown-toggle" aria-expanded="true" data-toggle="dropdown" type="button">
                    <i class="fa fa-arrow"></i>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div role="menu" class="dropdown-menu default">
                    <p>
                        <strong>From:</strong> 
                        <?php 
                            if($model->type == 'inbox'){
                                echo $model->mailfrom;
                            }else{
                                echo \Yii::$app->params['admin_email']; 
                            }
                        ?>
                    </p> 
                    <p>
                        <?php
                            
                            echo '<strong>To:</strong> ';
                            if($model->type == 'inbox'){
                                echo \Yii::$app->params['admin_email'];
                            }else{
                                $address = explode(',', $model->mailto);
                                foreach ($address as $key) {
                                    echo $key.', ';
                                }
                            }
                            
                        ?>
                    </p>
                    <p><strong>Date:</strong> <?= date_format(date_create($model->create_time), "F j, Y, g:i a"); ?></p>
                    <p><strong>Subject:</strong> <?= $model->subject; ?></p>
                </div>
            </div>
            <hr>

            <?=
                $model->message;
            ?>
                
            </div>
    </div>

    

</div>
