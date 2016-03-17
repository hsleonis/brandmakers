<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Mail */

$this->title = 'Compose';
$this->params['breadcrumbs'][] = ['label' => 'Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-create">
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
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="col-md-10">
       		<div class="form-group text-right" style="margin-top:15px;">
	       		<?= Html::a('Save as Draft', ['draft'], ['class' => 'btn btn-primary save_draft']) ?>
	       		<?= Html::a('Discard', ['discard'], ['class' => 'btn btn-danger discard_mail']) ?>
	        </div>

            <div class="pane" style="float:left; width:100%;">
                <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
            </div>
        
    </div>
    

</div>
