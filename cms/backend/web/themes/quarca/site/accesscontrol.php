<?php
	$this->title = "Manage User Access";
	$this->params['breadcrumbs'][] = $this->title;
?>

<a href="<?php echo \yii\helpers\Url::toRoute(['admin/route']); ?>" class="btn btn-sm btn-primary">Manage Route</a>
<a href="<?php echo \yii\helpers\Url::toRoute(['admin/role']); ?>" class="btn btn-sm btn-primary">Manage Role</a>
<a href="<?php echo \yii\helpers\Url::toRoute(['admin/assignment']); ?>" class="btn btn-sm btn-primary">Manage User Assignment</a>