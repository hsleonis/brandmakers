<?php

namespace backend\controllers;

use Yii;
use backend\models\Menu;
use backend\models\MenuSearch;
use backend\models\MenuPageRels;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'menu_items', 'save_sorted_menu', 'get_menu'],
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

    public function actionGet_menu(){

        if( Yii::$app->request->isAjax ){

            $menu_id=$_POST['id'];
            $html = '';

                $parent = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>0,'menu_id'=>$menu_id])->all();
                if(!empty($parent)){
                    foreach ($parent as $key) {
                        $html .= '<li id="menuItem_'.$key->page_id.'">';
                            $html .= MenuPageRels::test($key->page_id,$key->item_title,$key->page_rel->page_title);
                            $child_1 = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>$key->page_id,'menu_id'=>$menu_id])->all();

                            if(!empty($child_1)){
                                $html .= '<ol>';
                                foreach ($child_1 as $key_1) {
                                    $html .= '<li id="menuItem_'.$key_1->page_id.'">';
                                        $html .= MenuPageRels::test($key_1->page_id,$key_1->item_title,$key_1->page_rel->page_title);
                                        $child_2 = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>$key_1->page_id,'menu_id'=>$menu_id])->all();
                                        if(!empty($child_2)){
                                            $html .= '<ol>';
                                            foreach ($child_2 as $key_2) {
                                                $html .= '<li  id="menuItem_'.$key_2->page_id.'">';
                                                    $html .= MenuPageRels::test($key_2->page_id,$key_2->item_title,$key_2->page_rel->page_title);
                                                    $child_3 = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>$key_2->page_id,'menu_id'=>$menu_id])->all();
                                                    if(!empty($child_3)){
                                                        $html .= '<ol>';
                                                        foreach ($child_3 as $key_3) {
                                                            $html .= '<li id="menuItem_'.$key_3->page_id.'">';
                                                                $html .= MenuPageRels::test($key_3->page_id,$key_3->item_title,$key_3->page_rel->page_title);
                                                            $html .= '</li>';
                                                        }
                                                        $html .= '</ol>';
                                                    }
                                                $html .= '</li>';
                                            }
                                            $html .= '</ol>';
                                        }
                                    $html .= '</li>';
                                }
                                $html .= '</ol>';
                            }
                        $html .= '</li>';
                    }
                }


            exit(json_encode(array('result' => $html)));
        }
    }

    public function actionSave_sorted_menu(){
        if( Yii::$app->request->isAjax ){
            $menu_id=$_POST['menu_id'];
            $data=$_POST['data'];

            MenuPageRels::deleteAll('menu_id = :menu_id', [':menu_id' => $menu_id]);
            

            foreach ($data as $key) {
                $model = new MenuPageRels();

                if($key['item_id']!=0){
                    $model->item_title=$key['menu_title'];
                    $model->page_id=($key['item_id']=='')?0:$key['item_id'];
                    $model->parent_page_id=($key['parent_id']=='')?0:$key['parent_id'];
                    $model->menu_id=$menu_id;

                    $model->save();
                }
            }

            exit(json_encode(array('result' => 'success')));
        }
    }

    public function actionMenu_items(){
        return $this->render('menu_items');
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
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
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
