<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductPost;
use backend\models\ProductPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductPostController implements the CRUD actions for ProductPost model.
 */
class ProductpostController extends Controller
{
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


    public function actionSave_post_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];
            $product = $_POST['product'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $Post = ProductPost::find()->where(['product_id'=>$product,'id'=>$key])->one();

                    if(!empty($Post)){
                        $Post->sort_order = $i;
                        $Post->save();
                    }
                    $i++;
                }

                $response['result'] = 'success';
                $response['msg'] = 'Sort Order successfully saved.';
                $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'product_id' => $product
                                            ]);
            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving sort order.';
            }

            return json_encode($response);
        }
    }

    /**
     * Lists all ProductPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductPost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $response['view'] = $this->renderAjax('view', [
                                                'model' => $this->findModel($id),
                                            ]);
            
            return json_encode($response);
        }
    }

    /**
     * Creates a new ProductPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductPost();
        
        if (Yii::$app->request->isAjax) {
            $model->attributes = $_POST['ProductPost'];

            if($model->save()){

                $response['files'] = ['ok'];
                $response['result'] = 'success';
                $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'product_id' => $model->product_id
                                            ]);
                return json_encode($response);
            }else{
                $response['result'] = 'error';
                $response['files'] =  Html::errorSummary($model);
                return json_encode($response);
            }
            
        }
        else {
            
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {

            if(isset($_POST['id'])){
                $id = $_POST['id'];

                $model = $this->findModel($id);  
            }
            

            if (isset($_POST['ProductPost'])) {
                $model = $this->findModel($_POST['ProductPost']['id']);
                $model->attributes = $_POST['ProductPost'];
            
                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';
                    $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'product_id' => $model->product_id
                                            ]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            } else {
                
                $response['id'] = $model->id;
                $response['post_title'] = $model->post_title;
                $response['slug'] = $model->slug;
                $response['desc'] = $model->post_desc;
                /*$response['upload_view'] = $this->renderAjax('file_upload_view',[
                                                'ProductPost' => $model->id
                                            ]);

                $images = PostImageRel::find()->where(['post_id'=>$model->id])->all();
                $response['images_list'] = $this->renderAjax('uploaded_image_list', [
                                                'images' => $images
                                            ]);*/

                return json_encode($response);
            }
        }
    }

    /**
     * Deletes an existing ProductPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            if($this->findModel($id)->delete()){

                $response['files'] = ['ok'];
                $response['result'] = 'success';
                return json_encode($response);
            }else{
                $response['result'] = 'error';
                $response['files'] =  Html::errorSummary($model);
                return json_encode($response);
            }
            
        }
    }

    /**
     * Finds the ProductPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
