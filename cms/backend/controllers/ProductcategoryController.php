<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductCategory;
use backend\models\ProductCategorySearch;
use backend\models\ProductCategorySelfRel;
use backend\models\Product;
use backend\models\ProductImageRel;
use backend\models\ProductCategoryRel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\UploadedFile; 
use yii\helpers\Url;

/**
 * ProductcategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductcategoryController extends Controller
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
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'update', 'category_list', 'get_product_sub_cat','product_view' ,'upload_product'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],*/
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
            $category = $_POST['category'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $ProductCategoryRel = ProductCategoryRel::find()->where(['category_id'=>$category,'product_id'=>$key])->one();

                    if(!empty($ProductCategoryRel)){
                        $ProductCategoryRel->sort_order = $i;
                        $ProductCategoryRel->save();
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

    public function actionUpload_product(){
        if( Yii::$app->request->isAjax ){
            $model = new ProductCategory();
            $Product = new Product();
            $ProductImageRel = new ProductImageRel();
            $ProductCategoryRel = new ProductCategoryRel();

            $model_cat_title = UploadedFile::getInstance($model, 'cat_title');
            $time=time();

            $model_cat_title->saveAs('product_uploads/' . $time.$model_cat_title->baseName . '.' . $model_cat_title->extension);


            if($model_cat_title){
                $response = [];

                $Product->title = $_POST['title'];
                $Product->desc = $_POST['desc'];
                $Product->status = 1;

                if($Product->save()){
                    $ProductCategoryRel->category_id = $_POST['id'];
                    $ProductCategoryRel->product_id = $Product->id;

                    $ProductImageRel->product_id = $Product->id;
                    $ProductImageRel->image = $time.$model_cat_title->baseName . '.' . $model_cat_title->extension;

                    if($ProductCategoryRel->save() && $ProductImageRel->save()){
                        $response['files'][] = [
                            'name' => $time.$model_cat_title->name,
                            'type' => $model_cat_title->type,
                            'size' => $model_cat_title->size,
                            'url' => Url::base().'/product_uploads/' . $time.$model_cat_title->baseName . '.' . $model_cat_title->extension,
                            'deleteUrl' => Url::to(['delete_uploaded_file', 'file' => $model_cat_title->baseName . '.' . $model_cat_title->extension]),
                            'deleteType' => 'DELETE'
                        ];

                        $response['base'] = $time.$model_cat_title->baseName;
                        $response['view'] = $this->renderAjax('uploaded_product', [
                                'url' => Url::base().'/product_uploads/' . $time.$model_cat_title->baseName . '.' . $model_cat_title->extension,
                                'basename' => $time.$model_cat_title->baseName,
                                'id' => $ProductImageRel->id,
                                'model' =>$Product
                            ]);
                    }
                }else{

                    $response['errors'] = $product->getErrors();
                }

                

                

                return json_encode($response);
            }

        }
    }

    public function actionProduct_view(){

        if (Yii::$app->request->isAjax) {
            $this->layout = 'blank';

            $id = $_POST['id'];

            $model = ProductCategory::find()->where(['id'=>$id])->one();
            $data = ProductCategoryRel::find()->where(['category_id'=>$id])->orderBy('sort_order','DESC')->all();
            

            $response['upload_view'] = \yii\base\Controller::renderPartial('product_list_product_view', [
                                            'model' => $model,'data'=>$data
                                        ]);
            $response['Category_name'] = $model->cat_title;

            return json_encode($response);

        }
    }

    public function actionGet_product_sub_cat(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $child_categories_q = ProductCategory::find()->joinWith('cat_rel')->where(['product_category_self_rel.parent_cat_id'=>$id])->all();
            
            $html = '';
            if(!empty($child_categories_q)){
                $html .= '<ul>';
                foreach ($child_categories_q as $key) {
                    $html .= '<li><a href="#" data_cat_id="'.$key->id.'">'.$key->cat_title.'</a></li>';
                    $html .= ProductCategory::get_subcategory_list($key->id);
                }
                $html .= '</ul>';

                $response['files'] = ['msg'=> $html];
            }else{
                $response['files'] = ['msg'=> 'Sorry no subcategory found.'];
            }

            return json_encode($response);

        }
    }

    public function actionCategory_list(){
        $ProductCategorySelfRel = new ProductCategorySelfRel();
        $model = new ProductCategory();


        return $this->render('category_list', [
            'ProductCategorySelfRel' => $ProductCategorySelfRel, 'model' => $model
        ]);
    }

    /**
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCategory model.
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
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductCategory();
        $ProductCategorySelfRel = new ProductCategorySelfRel();

        if ($model->load(Yii::$app->request->post()) && $ProductCategorySelfRel->load(Yii::$app->request->post())) {

            if($model->save()){

                $ProductCategorySelfRel->cat_id = $model->id;
                if($ProductCategorySelfRel->parent_cat_id==''){
                    $ProductCategorySelfRel->parent_cat_id = array(0);
                }

                if(ProductCategory::update_ProductCategory_self_rel($ProductCategorySelfRel)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    var_dump($ProductCategorySelfRel->getErrors());
                }
            }
            else{
                var_dump($model->getErrors());
            }

        } 
        else {
            return $this->render('create', [
                'model' => $model, 'ProductCategorySelfRel'=>$ProductCategorySelfRel
            ]);
        }
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ProductCategorySelfRel_q = ProductCategorySelfRel::find()->where(['cat_id'=>$id])->all();

        if(empty($ProductCategorySelfRel_q)){
            $ProductCategorySelfRel = new ProductCategorySelfRel();
        }else{
            $ProductCategorySelfRel = new ProductCategorySelfRel();
            $ProductCategorySelfRel->parent_cat_id = ArrayHelper::getColumn($ProductCategorySelfRel_q, 'parent_cat_id');
        }

        if ($model->load(Yii::$app->request->post()) && $ProductCategorySelfRel->load(Yii::$app->request->post())) {
            
            if($model->save()){

                $ProductCategorySelfRel->cat_id = $model->id;
                if(empty($ProductCategorySelfRel->parent_cat_id)){

                    ProductCategorySelfRel::deleteAll(['cat_id' => $ProductCategorySelfRel->cat_id]);

                    $ProductCategorySelfRel->parent_cat_id = 0;
                    $ProductCategorySelfRel->save();
                }else{
                   
                    ProductCategory::update_ProductCategory_self_rel($ProductCategorySelfRel);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo '<pre>';
                var_dump($model->getErrors());
            }

        } 
        else {
            return $this->render('update', [
                'model' => $model, 'ProductCategorySelfRel'=>$ProductCategorySelfRel
            ]);
        }
    }

    /**
     * Deletes an existing ProductCategory model.
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
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
