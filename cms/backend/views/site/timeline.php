<?php

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\user;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timeline';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="timeline animated">
    
<?php
	foreach ($model as $key) {
		$user = User::find()->where(['id'=>$key['user_id']])->one();
?>

	<div class="timeline-row active">
        <div class="timeline-time">
            <?= date_format(date_create($key['created_at']), 'g:i A'); ?><small><?= date_format(date_create($key['created_at']), 'd-m-Y'); ?></small>
        </div>
        <div class="timeline-icon">
            <div class="danger-bg">
                <img src="<?php echo Url::base(); ?>/user_img/<?php echo $user->image; ?>" alt="User Picture" width="50">
            </div>
        </div>
        <div class="panel timeline-content">
            <div class="panel-body">
                <h2 class="text-info"><?= $user->name; ?></h2>
                <p>
                	<?= $key['message']; ?>
                </p>
            </div>
        </div>
    </div>
<?php
	}
?>

   



</div>