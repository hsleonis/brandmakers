<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Page;
use newerton\jcrop\jCrop;


/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */
    



?>


        <?php
            echo jCrop::widget([
                // Image URL
                'url' => $url,
                // options for the IMG element
                'imageOptions' => [
                    'id' => 'imageId',
                    'width' => 550,
                    'alt' => 'Crop this image'
                ],
                // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
                'jsOptions' => array(
                    'minSize' => [50, 50],
                    'aspectRatio' => 1,
                    'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
                    //customization
                    'bgColor' => '#FF0000',
                    'bgOpacity' => 0.4,
                    'selection' => true,
                    'theme' => 'light',
                ),
                // if this array is empty, buttons will not be added
                'buttons' => array(
                    'start' => array(
                        'label' => 'Adjust thumbnail cropping',
                        'htmlOptions' => array(
                            'class' => 'myClass',
                            'style' => 'color:red;'
                        )
                    ),
                    'crop' => array(
                        'label' => 'Apply cropping',
                    ),
                    'cancel' => array(
                        'label' => 'Cancel cropping'
                    )
                ),
                // URL to send request to (unused if no buttons)
                'ajaxUrl' => 'controller/ajaxcrop',
                // Additional parameters to send to the AJAX call (unused if no buttons)
                'ajaxParams' => ['someParam' => 'someValue'],
            ]);
        ?>
