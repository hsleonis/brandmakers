<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = 'Update Page: ' . ' ' . $model->page_title;
$this->params['breadcrumbs'][] = ['label' => 'Page List', 'url' => ['list']];
foreach ($breadcumb as $key) {
            $this->params['breadcrumbs'][] = ['label' => $key['title'], 'url' => ['list_view', 'id' => $key['id']]];
        }
$this->params['breadcrumbs'][] = $model->page_title;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-update">

    <?= $this->render('_form_update', [
        'model' => $model, 'PageSelfRels_model'=>$PageSelfRels_model,'image_rel_model'=>$image_rel_model,
        'PageTypeRel_model'=>$PageTypeRel_model, 'PageImageRel_model'=>$PageImageRel_model,'posts'=>$posts, 
        'PageTagsRel_model'=>$PageTagsRel_model

    ]) ?>

</div>
