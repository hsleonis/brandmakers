<?php

namespace backend\controllers;

use Yii;
use backend\models\Slider;
use backend\models\SliderSearch;
use backend\models\SliderImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; 
use yii\helpers\Url;
use yii\imagine\Image;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller
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

    /**
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
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
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $SliderImage_model = new SliderImage();
        $images = SliderImage::find()->where(['slider_id'=>$id])->orderBy('sort_order asc')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model, 'SliderImage_model'=>$SliderImage_model, 'images'=>$images
            ]);
        }
    }


    public function actionUpload_image(){
        if( Yii::$app->request->isAjax ){
            $SliderImage_model = new SliderImage();
            //$count = SliderImage::find()->where(['slider_id' => $_POST['id']])->count();

            $image = UploadedFile::getInstance($SliderImage_model, 'image');
            $time=time();

            
            $SliderImage_model->slider_id = $_POST['id'];
            $SliderImage_model->image = $time.$image->baseName . '.' . $image->extension;
            //$rel_model->sort_order = $count+1;

            if($SliderImage_model->save()){
                $response = [];

                $image->saveAs('slider_images/' . $time.$image->baseName . '.' . $image->extension);

                Image::thumbnail('@webroot/slider_images/'.$time.$image->baseName . '.' . $image->extension, 120, 80)
                    ->save(Yii::getAlias('@webroot').'/slider_images/thumb/'.$time.$image->baseName . '.' . $image->extension, ['quality' => 80]);

                $view = $this->renderAjax('_image_uploaded_view', [
                                'url' => Url::base().'/slider_images/' . $time.$image->baseName . '.' . $image->extension,
                                'basename' => $time.$image->baseName,
                                'id' => $SliderImage_model->id,
                                'model' => $SliderImage_model
                            ]);

                $response['view'] = $view;

                return json_encode($response);
            }

        }
    }

    public function actionSave_image_info(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $SliderImage_model = SliderImage::find()->where(['id'=>$id])->one();
            

            $response = [];
            if(!empty($SliderImage_model)){
                $SliderImage_model->short_title = $_POST['title'];
                $SliderImage_model->short_desc = $_POST['desc']; 

                if($SliderImage_model->save()){
                    $response['files'] = ['msg'=> 'Data saved successfully'];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }


    public function actionDelete_uploaded_image(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $image_rel_model = SliderImage::find()->where(['id'=>$id])->one();
            $name = $image_rel_model->image;

            $response = [];
            if(!empty($image_rel_model) && $image_rel_model->delete()){
                unlink(\Yii::getAlias('@webroot').'/slider_images/'.$name);
                unlink(\Yii::getAlias('@webroot').'/slider_images/thumb/'.$name);

                
                $response['files'] = ['msg'=> 'Image deleted successfully'];

            }else{
                $response['files'] = ['msg'=> 'Image File not found in database'];
            }

            return json_encode($response);
            
        }
    }

    public function actionSave_image_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];
            $slider = $_POST['slider'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $SliderImage = SliderImage::find()->where(['slider_id'=>$slider,'id'=>$key])->one();

                    if(!empty($SliderImage)){
                        $SliderImage->sort_order = $i;
                        $SliderImage->save();
                    }
                    $i++;
                }

                $response['result'] = 'success';
                $response['msg'] = 'Sort Order successfully saved.';

            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving sort order.';
            }

            return json_encode($response);
        }
    }

    /**
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $SliderImages = SliderImage::find()->where(['slider_id'=>$id])->all();
        foreach ($SliderImages as $key) {
            unlink(\Yii::getAlias('@webroot').'/slider_images/'.$key->image);
            unlink(\Yii::getAlias('@webroot').'/slider_images/thumb/'.$key->image);

            $key->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
