
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use backend\models\PostImageRel;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $PostImageRel_model = new PostImageRel(); ?>
        <?= FileInput::widget([
            'model' => $PostImageRel_model,
            'attribute' => 'image',
            'options'=>[
                'multiple'=>true
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/post/upload_file']),
                'uploadExtraData' => [
                    'id' => $post_id,
                    'cat_id' => 'Nature'
                ],
                'maxFileCount' => 10,
                
            ],
            'pluginEvents' => [
                'fileuploaded'=>'function(event, data, previewId, index){
                    $(".uploaded_post_image_cont").prepend(data.response.view);
                    
                }',
                'filebatchuploadcomplete' => 'function(event, files, extra){
                    $(".fileinput-remove-button").click();
                }'
            ]
        ]);
    ?>
