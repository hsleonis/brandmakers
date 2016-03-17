<?php
namespace backend\controllers;

use Yii;
use backend\models\ActivityLog;


class MyGlobalClass extends \yii\web\Controller{
    public function beforeAction($action)
    {
        
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        return parent::beforeAction($action);
    }

    public static function log_activity($message){
    	
    	$model = new ActivityLog();
    	$model->message = $message;
    	$model->save();
    }
}