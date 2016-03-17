<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductCategoryRel;
use backend\models\ProductImageRel;
use backend\models\ProductSpecification;
use backend\models\ProductFiles;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use yii\web\UploadedFile; 
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\imagine\Image;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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


    public function actionSave_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];
            $product = $_POST['product'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $ProductImageRel = ProductImageRel::find()->where(['product_id'=>$product,'id'=>$key])->one();

                    if(!empty($ProductImageRel)){
                        $ProductImageRel->sort_order = $i;
                        $ProductImageRel->save();
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGet_product_view()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $response['update_view'] = \yii\base\Controller::renderPartial('view', [
                                'model' => $this->findModel($id),
                            ]);

            return json_encode($response);
        }
    }

    public function actionGet_update_data(){
        if (Yii::$app->request->isAjax) {

            $id = $_POST['id'];

            $model_q = new ProductSpecification();
            $query = ProductSpecification::find()->indexBy('id'); // where `id` is your primary key
            $query->andWhere(['=','product_id',$id]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                /*'pagination' => [
                    'pagesize' => 5
                ]*/
            ]);
            $models = $dataProvider->getModels();
            

            $model = $this->findModel($id);
            $ProductCategoryRel_model_q = ProductCategoryRel::find()->where(['product_id'=>$id])->all();
            $ProductImageRel = new ProductImageRel();


            if(empty($ProductCategoryRel_model_q)){
                $ProductCategoryRel = new ProductCategoryRel();
            }else{
                $ProductCategoryRel = new ProductCategoryRel();
                $ProductCategoryRel->category_id = ArrayHelper::getColumn($ProductCategoryRel_model_q, 'category_id');
            }

            $response['update_view'] = $this->renderAjax('update_ajax', [
                                                'model' => $model, 'ProductCategoryRel'=>$ProductCategoryRel, 'ProductImageRel'=>$ProductImageRel,
                                                'dataProvider'=>$dataProvider,'model_q'=>$model_q
                                        ]);

            return json_encode($response);

        }
    }


    

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $ProductCategoryRel = new ProductCategoryRel();

        if ($model->load(Yii::$app->request->post()) && $ProductCategoryRel->load(Yii::$app->request->post())) {
            
            if($model->save()){

                $ProductCategoryRel->product_id = $model->id;
                if($ProductCategoryRel->category_id==''){
                    $ProductCategoryRel->category_id = array(0);
                }

                if(Product::update_product_category_rel($ProductCategoryRel)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    var_dump($ProductCategoryRel->getErrors());
                }


                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->getErrors());
            }
            
        } else {
            return $this->render('create', [
                'model' => $model, 'ProductCategoryRel'=>$ProductCategoryRel
            ]);
        }
    }


    public function actionUpload_image(){
        if( Yii::$app->request->isAjax ){
            $rel_model = new ProductImageRel();

            $rel_model_image = UploadedFile::getInstance($rel_model, 'image');
            $time=time();
            $userId = \Yii::$app->user->identity->id;
            $image_name = $time.'_'.$userId.'_'.$rel_model_image->baseName . '.' . $rel_model_image->extension;

            $rel_model_image->saveAs('product_uploads/' . $image_name);

            $rel_model->product_id = $_POST['id'];
            $rel_model->image = $image_name;

            if($rel_model->save()){
                $response = [];

                Image::thumbnail('@webroot/product_uploads/'.$image_name, 220, 150)
                    ->save(Yii::getAlias('@webroot').'/product_uploads/thumb/'.$image_name, ['quality' => 100]);


                $view = $this->renderAjax('_image_upload', [
                                'url' => Url::base().'/product_uploads/' . $image_name,
                                'basename' => $time.'_'.$userId.'_'.$rel_model_image->baseName,
                                'id' => $rel_model->id,
                                'model'=>$rel_model
                            ]);


                $response['view'] = $view;

                return json_encode($response);
            }else{
                $response['error'] = $rel_model->getErrors();
                $response['id'] = $_POST['id'];
                return json_encode($response);
            }

        }
    }

    public function actionUpload_file(){
        if( Yii::$app->request->isAjax ){
            $file_model = new ProductFiles();

            $file_model_file = UploadedFile::getInstance($file_model, 'file_name');
            $time=time();
            $userId = \Yii::$app->user->identity->id;
            $file_name = $time.'_'.$userId.'_'.trim($file_model_file->baseName) . '.' . $file_model_file->extension;

            $file_model_file->saveAs('product_files/' . $file_name);

            $file_model->product_id = $_POST['id'];
            $file_model->file_name = $file_name;
            $file_model->title = $file_model_file->baseName;

            if($file_model->save()){
                $response = [];

                $view = $this->renderAjax('_file_upload', [
                                /*'url' => Url::base().'/product_files/' . $file_name,
                                'basename' => $time.'_'.$userId.'_'.$file_model_file->baseName,
                                'id' => $file_model->id,*/
                                'model'=>$file_model
                            ]);


                $response['view'] = $view;

                return json_encode($response);
            }else{
                $response['error'] = $file_model->getErrors();
                $response['id'] = $_POST['id'];
                return json_encode($response);
            }

        }
    }

    public function actionDelete_uploaded_image(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $ProductImageRel_model = ProductImageRel::find()->where(['id'=>$id])->one();
            $name = $ProductImageRel_model->image;

            $response = [];
            if(!empty($ProductImageRel_model) && $ProductImageRel_model->delete()){
                unlink(\Yii::getAlias('@webroot').'/product_uploads/'.$name);
                unlink(\Yii::getAlias('@webroot').'/product_uploads/thumb/'.$name);

                $response['files'] = ['msg'=> 'File deleted successfully'];

            }else{
                $response['files'] = ['msg'=> 'Image File not found in database'];
            }

            return json_encode($response);
            
        }
    }

    public function actionDelete_uploaded_file(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $file_model = ProductFiles::find()->where(['id'=>$id])->one();
            $name = $file_model->file_name;

            $response = [];
            if(!empty($file_model) && $file_model->delete()){
                unlink(\Yii::getAlias('@webroot').'/product_files/'.$name);

                $response['files'] = ['msg'=> 'File deleted successfully'];

            }else{
                $response['files'] = ['msg'=> 'File not found in database'];
            }

            return json_encode($response);
            
        }
    }


    public function actionSave_product_image_details(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $ProductImageRel_model = ProductImageRel::find()->where(['id'=>$id])->one();
            

            $response = [];
            if(!empty($ProductImageRel_model)){
                $ProductImageRel_model->title = $_POST['title'];
                $ProductImageRel_model->desc = $_POST['desc'];
                $ProductImageRel_model->is_gallery = $_POST['is_gallery'];
                $ProductImageRel_model->is_banner = $_POST['is_banner'];
                $ProductImageRel_model->is_hover = $_POST['is_hover'];

                if($ProductImageRel_model->save()){
                    $response['files'] = ['msg'=> 'Data saved successfully'];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model_q = new ProductSpecification();
        $query = ProductSpecification::find()->indexBy('id'); // where `id` is your primary key
        $query->andWhere(['=','product_id',$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*'pagination' => [
                'pagesize' => 5
            ]*/
        ]);
        $models = $dataProvider->getModels();

        
        if (Yii::$app->request->isAjax) {

            if (isset($_POST['ProductSpecification']) && isset($_POST['ProductSpecification']['cat_create']) ) {

                $model_q = new ProductSpecification();
                $model_q->attributes = $_POST['ProductSpecification'];
            
                if($model_q->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';

                    $model_uu = new ProductSpecification();
                    $query = ProductSpecification::find()->indexBy('id'); // where `id` is your primary key
                    $query->andWhere(['=','product_id',$id]);
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        /*'pagination' => [
                            'pagesize' => 5
                        ]*/
                    ]);
                    $models = $dataProvider->getModels();

                    $product_specifications = ProductSpecification::find()->where(['product_id'=>$id])->all();
                    $response['preview_cont'] = $this->renderAjax('specification_preview', ['data'=>$product_specifications]);



                    $response['specification_list'] = $this->renderAjax('ajax_cont', ['dataProvider'=>$dataProvider,'model_q'=>$model_uu]);
                    return json_encode($response);
                }else{
                    var_dump($_POST['ProductSpecification']);
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model_q);
                    return json_encode($response);
                }
            }
            else if (ProductSpecification::loadMultiple($models, Yii::$app->request->post()) && ProductSpecification::validateMultiple($models)) {
                $count = 0;
                foreach ($models as $index => $model_q) {
                    // populate and save records for each model
                    if ($model_q->save()) {
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
                $response['files'] = "Processed {$count} records successfully.";
                $response['result'] = 'success';

                return json_encode($response);
            }
            else if(isset($_POST['is_banner'])){
                $model_uu = new ProductSpecification();
                $query = ProductSpecification::find()->indexBy('id'); // where `id` is your primary key
                $query->andWhere(['=','product_id',$id]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                   /* 'pagination' => [
                        'pagesize' => 5
                    ]*/
                ]);
                $models = $dataProvider->getModels();

                $product_specifications = ProductSpecification::find()->where(['product_id'=>$id])->all();
                $response['preview_cont'] = $this->renderAjax('specification_preview', ['data'=>$product_specifications]);


                $response['specification_list'] = $this->renderAjax('ajax_cont', ['dataProvider'=>$dataProvider,'model_q'=>$model_uu]);
                return json_encode($response);
            }
        }





        $model = $this->findModel($id);
        $ProductCategoryRel_model_q = ProductCategoryRel::find()->where(['product_id'=>$id])->all();
        $ProductImageRel = new ProductImageRel();

        if(empty($ProductCategoryRel_model_q)){
            $ProductCategoryRel = new ProductCategoryRel();
        }else{
            $ProductCategoryRel = new ProductCategoryRel();
            $ProductCategoryRel->category_id = ArrayHelper::getColumn($ProductCategoryRel_model_q, 'category_id');
        }

        if ($model->load(Yii::$app->request->post()) && $ProductCategoryRel->load(Yii::$app->request->post())) {

            if($model->save()){

                $ProductCategoryRel->product_id = $model->id;
                if(empty($ProductCategoryRel->category_id)){

                    ProductCategoryRel::deleteAll(['product_id' => $ProductCategoryRel->product_id]);

                    $ProductCategoryRel->category_id = 0;
                    $ProductCategoryRel->save();
                }else{
                   
                    Product::update_product_category_rel($ProductCategoryRel);
                }


                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->getErrors());
            }
            
        } else {
            return $this->render('update', [
                'model' => $model, 'ProductCategoryRel'=>$ProductCategoryRel ,'ProductImageRel'=>$ProductImageRel,
                'dataProvider'=>$dataProvider,'model_q'=>$model_q
            ]);
        }
    }

    public function actionUpdate_ajax()
    {
        if (Yii::$app->request->isAjax) {



            if (isset($_POST['Product'])) {
                $model = $this->findModel($_POST['Product']['id']);
                $model->attributes = $_POST['Product'];
            
                if($model->save()){
                    $ProductCategoryRel = new ProductCategoryRel();

                    $ProductCategoryRel->product_id = $model->id;
                    if(empty($_POST['ProductCategoryRel'])){

                        ProductCategoryRel::deleteAll(['product_id' => $ProductCategoryRel->product_id]);

                        $ProductCategoryRel->category_id = 0;
                        $ProductCategoryRel->save();
                    }else{
                        $ProductCategoryRel->category_id = $_POST['ProductCategoryRel']['category_id'];
                        Product::update_product_category_rel($ProductCategoryRel);
                    }

                    $response['files'] = '<img src="'.Url::base().'/product_uploads/' .$model->product_image[0]->image.'" alt="'.$model->product_image[0]->image.'" width="100%">';
                    $response['id'] = $model->id;
                    $response['title'] = $model->title;
                    $response['result'] = 'success';
                    
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            }
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        ProductCategoryRel::deleteAll(['product_id' => $id]);

        $images = ProductImageRel::findAll(['product_id' => $id]);
        if(!empty($images)){
           foreach ($images as $key => $value) {
                unlink(\Yii::getAlias('@webroot').'/product_uploads/'.$value->image);
            } 
        }
        ProductImageRel::deleteAll(['product_id' => $id]);

        $files = ProductFiles::findAll(['product_id' => $id]);
        if(!empty($files)){
           foreach ($files as $key => $value) {
                unlink(\Yii::getAlias('@webroot').'/product_files/'.$value->file_name);
            } 
        }
        ProductFiles::deleteAll(['product_id' => $id]);
        ProductSpecification::deleteAll(['product_id' => $id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
