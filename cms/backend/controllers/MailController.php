<?php

namespace backend\controllers;

use Yii;
use backend\models\Mail;
use backend\models\MailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * MailController implements the CRUD actions for Mail model.
 */
class MailController extends Controller
{
    public function beforeAction($action){
        if(Yii::$app->params['setup.status']!="Installed"){
            return $this->redirect(['/setup/index']);
        }
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

   

public function actionIndex()
    {
        $data = Mail::find()->where(['type'=>'inbox','trash'=>0])->orderBy('id desc')->all();

        return $this->render('index', [
            'data' => $data,
        ]);
    }



public function actionSent()
    {
        $data = Mail::find()->where(['type'=>'sent','trash'=>0])->orderBy('id desc')->all();

        return $this->render('sent', [
            'data' => $data,
        ]);
    }



public function actionDraft()
    {
        $data = Mail::find()->where(['type'=>'draft','trash'=>0])->orderBy('id desc')->all();

        return $this->render('draft', [
            'data' => $data,
        ]);
    }


public function actionTrash()
    {
        $data = Mail::find()->where(['trash'=>1])->orderBy('id desc')->all();

        return $this->render('trash', [
            'data' => $data,
        ]);
    }



public function actionV($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



public function actionCompose()
    {
        $model = new Mail;
        $model->scenario = 'mail';

        if (Yii::$app->request->isAjax) {

            if (isset($_POST['Mail'])) {
                $model->attributes = $_POST['Mail'];
                $model->type = 'sent';

                $to = explode(',', $model->mailto);
                $cc = explode(',', $model->cc);
                $bcc = explode(',', $model->bcc);

                
                $valid = $model->validate();

                if($valid){
                    try{
                        $message = Yii::$app->mailer->compose();

                        $message->setFrom(\Yii::$app->params['admin_email']);
                        $message->setTo($to);

                        if(!empty($model->cc)){
                            $message->setCc($cc);
                        }
                        if(!empty($model->bcc)){
                            $message->setBcc($bcc);
                        }
                        $message->setSubject($model->subject);
                        $message->setHtmlBody($model->message);
                        $message->send();

                        if($model->save()){
                            $response['result'] = ['success'];
                            $response['files'] = ['ok'];
                        }else{
                            $response['files'] = Html::errorSummary($model);
                        }
                    }catch(Exception $e){
                        $response['files'] = $e;
                    }
                }else{
                    $response['result'] = ['error'];
                    $response['files'] = Html::errorSummary($model);
                }
                    
                
                return json_encode($response);
                
            }

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }



public function actionSave_draft()
    {
        $model = new Mail;
        $model->scenario = 'draft';

        if (Yii::$app->request->isAjax) {

            if (isset($_POST['data'])) {

                parse_str($_POST['data'], $dataarray);
                $model->attributes = $dataarray['Mail'];

                $model->type = 'draft';

                $to = explode(',', $model->mailto);
                $cc = explode(',', $model->cc);
                $bcc = explode(',', $model->bcc);

                
                $valid = $model->validate();

                if($valid){
                    try{

                        if($model->save()){
                            $response['result'] = ['success'];
                            $response['files'] = ['ok'];
                        }else{
                            $response['files'] = Html::errorSummary($model);
                        }

                    }catch(Exception $e){
                        $response['files'] = $e;
                    }
                }else{
                    $response['result'] = ['error'];
                    $response['files'] = Html::errorSummary($model);
                }
                    
                
                return json_encode($response);
                
            }

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */


public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
protected function findModel($id)
    {
        if (($model = Mail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





public function actionTrash_item(){
    $model = new Mail;
    $model->scenario = 'trash';

    if (Yii::$app->request->isAjax) {

        if (isset($_POST['data'])) {


            try{

                foreach ($_POST['data'] as $value) {

                    $model = $this->findModel($value);
                    $model->trash = 1;

                    $model->save();
                }

                $response['result'] = ['success'];
                $response['files'] = ['ok'];

            }catch(Exception $e){
                $response['files'] = $e;
            }

            return json_encode($response);
            
        }

    }

}

public function actionRestore_item(){
    $model = new Mail;
    $model->scenario = 'restore';

    if (Yii::$app->request->isAjax) {

        if (isset($_POST['data'])) {


            try{

                foreach ($_POST['data'] as $value) {

                    $model = $this->findModel($value);
                    $model->trash = 0;

                    $model->save();
                }

                $response['result'] = ['success'];
                $response['files'] = ['ok'];

            }catch(Exception $e){
                $response['files'] = $e;
            }

            return json_encode($response);
            
        }

    }

}


public function actionRemove_item(){
    $model = new Mail;
    $model->scenario = 'remove';

    if (Yii::$app->request->isAjax) {

        if (isset($_POST['data'])) {


            try{

                foreach ($_POST['data'] as $value) {

                    $this->findModel($value)->delete();
                }

                $response['result'] = ['success'];
                $response['files'] = ['ok'];

            }catch(Exception $e){
                $response['files'] = $e;
            }

            return json_encode($response);
            
        }

    }

}




}



