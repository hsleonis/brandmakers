<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
/*use dosamigos\ckeditor\CKEditor;*/
use backend\models\Page;
/*use dosamigos\fileupload\FileUploadUI;*/
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */
    $this->registerCssFile(Url::base()."/css/jquery.steps.css");
    $this->registerCssFile(Url::base()."/css/normalize.css");

    $this->registerJsFile(Url::base()."/js/jquery.steps.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    /*$this->registerJs("
                    $('#wizard').steps({
                        headerTag: 'h2',
                        bodyTag: 'section',
                        transitionEffect: 'slideLeft'
                    });
    ", yii\web\View::POS_READY, 'step_activate');*/

$model->date = date('Y-m-d');

?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


<div class="page-form">

    


            <div id="wizard">

                <section class="first_step">
                    <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="col-md-4">
                                <label>Parent Page</label>
                                <?= 
                                    Select2::widget([
                                        'model' => $PageSelfRels_model, 
                                        'attribute' => 'parent_page_id',
                                        'data' => Page::getHierarchy_page(),
                                        'options' => ['placeholder' => 'Select parent page ...','multiple'=>true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>
                                <br/>

                                <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'page_slug')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'short_desc')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'meta_key')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'meta_desc')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'date')->widget(
                                        DatePicker::className(), [
                                            // inline too, not bad
                                            'inline' => false, 
                                            // modify template for custom rendering
                                            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd'
                                            ]
                                    ]);?>

                                <?= $form->field($model, 'status')
                                                        ->dropDownList(
                                                            array ('active'=>'Active', 'archive'=>'Archive') 
                                                        ); ?>

                                <?php
                                    $data = array ('Home page'=>'Home page', 
                                                   'Contact page'=>'Contact page', 
                                                   'Service Page'=>'Service Page', 
                                                   'Project'=>'Project', 
                                                   'News'=>'News'
                                                    )
                                ?>




                        </div>

                        <div class="col-md-8">

                                <label>Page Types</label>
                                <?= Select2::widget([
                                        'model' => $PageTypeRel_model, 
                                        'attribute' => 'page_type',
                                        'data' => $data,
                                        'options' => ['placeholder' => 'Select page Type ...','multiple'=>true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                <br/>

                                <?= $form->field($model, 'page_desc')->textArea(['rows' => '6','id'=>'editor']) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Create', ['class' => 'btn btn-default']) ?>
                                </div>

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </section>
                
            </div>

    

</div>
<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor", {
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_post');

?>