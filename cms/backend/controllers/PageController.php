<?php

namespace backend\controllers;

use Yii;
use backend\models\Page;
use backend\models\PageSearch;
use backend\models\PageSelfRels;
use backend\models\PageImageRel;
use backend\models\PageTypeRel;
use backend\models\MenuPageRels;
use backend\models\PageTagsRel;
use backend\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile; 
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use backend\controllers\MyGlobalClass;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'upload_file','delete_uploaded_file',
                        'list', 'list_view'],
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



    public function actionSave_page_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $page = Page::find()->where(['id'=>$key])->one();

                    if(!empty($page)){
                        $page->sort_order = $i;
                        $page->save();
                    }
                    $i++;
                }

                $response['result'] = 'success';
                $response['msg'] = 'Sort Order successfully saved.';
                /*$response['post_list'] = $this->renderAjax('list_of_post', [
                                                'product_id' => $product
                                            ]);*/
            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving sort order.';
            }

            return json_encode($response);
        }
    }
    

    public function actionArchive_list(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }else{
            $id = 0;
        }
        $pages = Page::find()->where(['page.is_archive'=>1])->all();

        return $this->render('archive_list',[
                'pages'=>$pages
            ]);
    }
    public function actionArchive($id){
        if (Yii::$app->request->isAjax) {

            $model = $this->findModel($id);
            

            $response = [];
            if(!empty($model)){
                $model->is_archive = 1;

                if($model->save()){

                    Page::archive_all_child($model->id);
                    
                    $response['files'] = ['msg'=> 'Page Archived successfully','id'=> $id];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    public function actionRestore_page($id){
        if (Yii::$app->request->isAjax) {

            $model = $this->findModel($id);
            

            $response = [];
            if(!empty($model)){
                $model->is_archive = 0;

                if($model->save()){

                    /*Page::restore_all_child($model->id);*/
                    
                    $response['files'] = ['msg'=> 'Page Restored successfully','id'=> $id];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    public function actionDelete_page($id){
        if (Yii::$app->request->isAjax) {

            $model = $this->findModel($id);

            PageSelfRels::updateAll(['parent_page_id' => 0], 'parent_page_id = '.$id);
            PageTypeRel::deleteAll(['page_id' => $id]);

            PageSelfRels::deleteAll(['page_id' => $id]);

            $images = PageImageRel::findAll(['page_id' => $id]);
            if(!empty($images)){
                foreach ($images as $key => $value) {
                    unlink(\Yii::getAlias('@webroot').'/uploads/'.$value->image);
                }
            }
            PageImageRel::deleteAll(['page_id' => $id]);

            MenuPageRels::deleteAll(['page_id' => $id]);
            MenuPageRels::deleteAll(['parent_page_id' => $id]);


            Post::deleteAll(['page_id' => $id]);

            $response = [];
            if($model->delete()){

                $response['files'] = ['msg'=> 'Page Deleted successfully','id'=> $id];

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);

        }
    }


    public function actionSave_image_info(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $PageImageRel_model = PageImageRel::find()->where(['id'=>$id])->one();
            

            $response = [];
            if(!empty($PageImageRel_model)){
                $PageImageRel_model->short_title = $_POST['title'];
                $PageImageRel_model->short_desc = $_POST['desc'];
                $PageImageRel_model->is_banner = $_POST['is_banner'];
                $PageImageRel_model->is_gallery = $_POST['is_gallery']; 

                if($PageImageRel_model->save()){
                    $response['files'] = ['msg'=> 'Data saved successfully'];
                }

            }else{
                $response['files'] = ['msg'=> 'Error saving data.'];
            }

            return json_encode($response);
            
        }
    }

    public function actionSave_page_image_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];
            $page = $_POST['page'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $PageImageRel = PageImageRel::find()->where(['page_id'=>$page,'id'=>$key])->one();

                    if(!empty($PageImageRel)){
                        $PageImageRel->sort_order = $i;
                        $PageImageRel->save();
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



    public function actionList($id=0){
        $model = Page::find()->where(['id'=>$id])->one();
        $pages_q = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$id,'page.is_archive'=>0])->orderBy('sort_order asc')->all();

        $pages = array();
        if(!empty($pages_q)){
            foreach ($pages_q as $key) {
                $child_count = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$key->id,'page.is_archive'=>0])->count();
                $key->child_count = $child_count;

                array_push($pages, $key);
            }
        }

        if($id==0){
            $breadcumb = '';
        }else{
            $breadcumb = array_reverse(Page::get_breadcumb($id));
        }
        

        
        return $this->render('page_list', ['model'=>$model, 'pages'=>$pages,'breadcumb'=>$breadcumb]);
    }

    public function actionList_view($id)
    {
        $child_pages_q = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$id,'page.is_archive'=>0])->orderBy('page.sort_order asc')->all();

        $breadcumb = array_reverse(Page::get_breadcumb($id));


        $child_pages = array();
        if(!empty($child_pages_q)){
            foreach ($child_pages_q as $key) {
                $child_count = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$key->id,'page.is_archive'=>0])->count();
                $key->child_count = $child_count;

                array_push($child_pages, $key);
            }
        }


        return $this->render('list_view', [
            'model' => $this->findModel($id),
            'child_pages' => $child_pages,
            'breadcumb' => $breadcumb
        ]);
    }

    public function actionUpload_file(){
        if( Yii::$app->request->isAjax ){
            $model = new Page();
            $rel_model = new PageImageRel();
            $count = PageImageRel::find()->where(['page_id' => $_POST['id']])->count();

            $uploaded_image = UploadedFile::getInstance($rel_model, 'image');
            $time=time();

            $uploaded_image->saveAs('uploads/' . $time.$uploaded_image->baseName . '.' . $uploaded_image->extension);

            $rel_model->page_id = $_POST['id'];
            $rel_model->image = $time.$uploaded_image->baseName . '.' . $uploaded_image->extension;
            $rel_model->sort_order = $count+1;

            if($rel_model->save()){
                $response = [];

                $this->layout = 'blank';
                $view = $this->renderAjax('_image_upload', [
                                'url' => Url::base().'/uploads/' . $time.$uploaded_image->baseName . '.' . $uploaded_image->extension,
                                'basename' => $time.$uploaded_image->baseName,
                                'id' => $rel_model->id,
                                'model' => $rel_model
                            ]);

                $response['files'][] = [
                    'name' => $time.$uploaded_image->name,
                    'type' => $uploaded_image->type,
                    'size' => $uploaded_image->size,
                    'url' => Url::base().'/uploads/' . $time.$uploaded_image->baseName . '.' . $uploaded_image->extension,
                    'deleteUrl' => Url::to(['delete_uploaded_file', 'file' => $uploaded_image->baseName . '.' . $uploaded_image->extension]),
                    'deleteType' => 'DELETE'
                ];

                /*$response['view'] = $view;*/
                $response['view'] = $view;
                $response['base'] = $time.$uploaded_image->baseName;

                return json_encode($response);
            }

        }
    }

    /*public function actionDelete_uploaded_file(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            unlink(\Yii::getAlias('@webroot').'/uploads/'.$name);

            $response = [];
            $response['files'][] = [
                    'name' => 'dddad.jpg',
                    'type' => 'JPEG',
                    'size' => 2000,
                    'url' => '',
                ];

            return json_encode($response);
        }
    }*/

    public function actionDelete_uploaded_file(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $image_rel_model = PageImageRel::find()->where(['id'=>$id])->one();
            $name = $image_rel_model->image;

            $response = [];
            if(!empty($image_rel_model) && $image_rel_model->delete()){
                unlink(\Yii::getAlias('@webroot').'/uploads/'.$name);

                
                $response['files'] = ['msg'=> 'File deleted successfully'];

            }else{
                $response['files'] = ['msg'=> 'Image File not found in database'];
            }

            return json_encode($response);
            
        }
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $model= $this->findModel($id);
        $child_pages_q = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$id])->all();

        $breadcumb = array_reverse(Page::get_breadcumb($id));


        $child_pages = array();
        if(!empty($child_pages_q)){
            foreach ($child_pages_q as $key) {
                $child_count = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$key->id])->count();
                $key->child_count = $child_count;

                array_push($child_pages, $key);
            }
        }


        MyGlobalClass::log_activity('Visited page - ID: '.$model->id.' and page title: '.$model->page_title);
        return $this->render('view', [
            'model' => $model,
            'child_pages' => $child_pages,
            'breadcumb' => $breadcumb
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();  
        $PageSelfRels_model = new PageSelfRels();
        $PageTypeRel_model = new PageTypeRel();
        
        $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
        $_SESSION['KCFINDER']['uploadURL'] = Url::base()."/kcupload/"; // URL for the uploads folder
        $_SESSION['KCFINDER']['uploadDir'] = Yii::getAlias('@app')."/web/kcupload/"; // path to the uploads folder
        
        if ($model->load(Yii::$app->request->post()) && $PageSelfRels_model->load(Yii::$app->request->post()) && $PageTypeRel_model->load(Yii::$app->request->post())) {

            if($model->save()){

                $PageSelfRels_model->page_id = $model->id;
                if($PageSelfRels_model->parent_page_id==''){
                    $PageSelfRels_model->parent_page_id = array(0);
                }

                $PageTypeRel_model->page_id = $model->id;
                if($PageTypeRel_model->page_type==''){
                    $PageTypeRel_model->page_type = array('');
                }


                if(Page::update_page_self_rel($PageSelfRels_model) && Page::update_page_type_rel($PageTypeRel_model)){

                    MyGlobalClass::log_activity('Created page - ID: '.$model->id.' and page title: '.$model->page_title);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    var_dump($PageSelfRels_model->getErrors());
                }
            }
            else{
                var_dump($model->getErrors());
            }
            
        } else {
            return $this->render('create', [
                'model' => $model, 'PageSelfRels_model'=>$PageSelfRels_model,
                'PageTypeRel_model'=>$PageTypeRel_model
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $PageSelfRels_model_q = PageSelfRels::find()->where(['page_id'=>$id])->all();
        $PageTypeRel_model_q = PageTypeRel::find()->where(['page_id'=>$id])->all();
        $PageImageRel_model = new PageImageRel();
        $PageTagsRel_model_q = PageTagsRel::find()->where(['page_id'=>$id])->all();

        $posts = Post::find()->where(['page_id'=>$id])->all();

        $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
        $_SESSION['KCFINDER']['uploadURL'] = Url::base()."/kcupload/"; // URL for the uploads folder
        $_SESSION['KCFINDER']['uploadDir'] = Yii::getAlias('@app')."/web/kcupload/"; // path to the uploads folder
        
        if(empty($PageSelfRels_model_q)){
            $PageSelfRels_model = new PageSelfRels();
        }else{
            $PageSelfRels_model = new PageSelfRels();
            $PageSelfRels_model->parent_page_id = ArrayHelper::getColumn($PageSelfRels_model_q, 'parent_page_id');
        }

        if(empty($PageTagsRel_model_q)){
            $PageTagsRel_model = new PageTagsRel();
        }else{
            $PageTagsRel_model = new PageTagsRel();
            $PageTagsRel_model->tag_id = ArrayHelper::getColumn($PageTagsRel_model_q, 'tag_id');
        }


        if(empty($PageTypeRel_model_q)){
            $PageTypeRel_model = new PageTypeRel();
        }else{
            $PageTypeRel_model = new PageTypeRel();
            $PageTypeRel_model->page_type = ArrayHelper::getColumn($PageTypeRel_model_q, 'page_type');
        }

        $image_rel_model = PageImageRel::find()->where(['page_id'=>$id])->orderBy('sort_order asc')->all();

            

        if ($model->load(Yii::$app->request->post())&& $PageTagsRel_model->load(Yii::$app->request->post()) && $PageSelfRels_model->load(Yii::$app->request->post()) && $PageTypeRel_model->load(Yii::$app->request->post())) {

            if($model->save()){

                $PageSelfRels_model->page_id = $model->id;
                if(empty($PageSelfRels_model->parent_page_id)){

                    PageSelfRels::deleteAll(['page_id' => $PageSelfRels_model->page_id]);

                    $PageSelfRels_model->parent_page_id = 0;
                    $PageSelfRels_model->save();
                }else{
                   
                    Page::update_page_self_rel($PageSelfRels_model);
                }

                $PageTagsRel_model->page_id = $model->id;
                if(empty($PageTagsRel_model->tag_id)){

                    PageTagsRel::deleteAll(['page_id' => $PageTagsRel_model->page_id]);
/*
                    $PageTagsRel_model->tag_id = 0;
                    $PageTagsRel_model->save();*/
                }else{
                   
                    Page::update_page_tags_rel($PageTagsRel_model);
                }

                $PageTypeRel_model->page_id = $model->id;
                if(empty($PageTypeRel_model->page_type)){
                    PageTypeRel::deleteAll(['page_id' => $PageTypeRel_model->page_id]);

                    $PageTypeRel_model->page_type = '';
                    $PageTypeRel_model->save();
                }else{
                   
                    Page::update_page_type_rel($PageTypeRel_model);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo '<pre>';
                var_dump($_POST['Page']);
                var_dump($model->getErrors());
            }
            
        } 
        else {
            $breadcumb = array_reverse(Page::get_breadcumb($id));

            return $this->render('update', [
                'model' => $model, 'PageSelfRels_model'=>$PageSelfRels_model,'image_rel_model'=>$image_rel_model,
                'breadcumb' => $breadcumb, 'PageTypeRel_model'=>$PageTypeRel_model, 'PageImageRel_model'=>$PageImageRel_model,
                'posts' => $posts, 'PageTagsRel_model'=>$PageTagsRel_model
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        PageSelfRels::updateAll(['parent_page_id' => 0], 'parent_page_id = '.$id);
        PageTypeRel::deleteAll(['page_id' => $id]);

        PageSelfRels::deleteAll(['page_id' => $id]);

        $images = PageImageRel::findAll(['page_id' => $id]);
        if(!empty($images)){
           foreach ($images as $key => $value) {
                unlink(\Yii::getAlias('@webroot').'/uploads/'.$value->image);
            } 
        }
        PageImageRel::deleteAll(['page_id' => $id]);

        MenuPageRels::deleteAll(['page_id' => $id]);
        MenuPageRels::deleteAll(['parent_page_id' => $id]);


        Post::deleteAll(['page_id' => $id]);
        

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
