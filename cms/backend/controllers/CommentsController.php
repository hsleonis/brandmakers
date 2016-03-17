<?php

namespace backend\controllers;

use Yii;
use backend\models\Comments;
use backend\models\CommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentsController implements the CRUD actions for Comments model.
 */
class CommentsController extends Controller
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


    public function actionApprove($id){
        if (Yii::$app->request->isAjax) {

            $model = $this->findModel($id);
            

            $response = [];
            if(!empty($model)){
                $model->is_approved = 1;

                if($model->save()){
                    
                    $response['files'] = ['msg'=> 'Comment Approved successfully','id'=> $id];
                }else{
                    $response['files'] = ['msg'=> $model->getErrors()];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    public function actionUnapprove($id){
        if (Yii::$app->request->isAjax) {

            $model = $this->findModel($id);
            

            $response = [];
            if(!empty($model)){
                $model->is_approved = 0;

                if($model->save()){
                    
                    $response['files'] = ['msg'=> 'Comment Unapproved successfully','id'=> $id];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    /**
     * Lists all Comments models.
     * @return mixed
     */
    public function actionIndex()
    {

        $data = Comments::find()->where(['is_approved'=>0])->all();

        return $this->render('index', [
            'data' => $data
        ]);
    }


    public function actionApproved_comments()
    {

        $data = Comments::find()->where(['is_approved'=>1])->all();

        return $this->render('approved_comments', [
            'data' => $data
        ]);
    }

    /**
     * Displays a single Comments model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comments model.
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
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteapproved($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['approved_comments']);
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
