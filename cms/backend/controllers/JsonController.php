<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use frontend\models\Page;
use frontend\models\Slider;
use frontend\models\Product;


use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use frontend\models\Menu;
use frontend\models\MenuPageRels;
use frontend\models\ProductCategorySelfRel;
use frontend\models\ProductCategory;


/**
 * Site controller
 */
class JsonController extends Controller
{

    public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['frontend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['frontend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['http://192.168.1.55:8080'],
                    'Access-Control-Request-Method' => ['GET'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionGet_menu(){

        if( Yii::$app->request->isAjax ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = [];

            $data_q = MenuPageRels::getMenu(6);

            $response['menu'] = $data_q;

            return $response;
        }

        return $this->render('index'/*,['menu'=>$menu]*/);
    }



    public function actionGet_landing_section(){

           // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = [];

            $data_q = MenuPageRels::getMenu_new(6);

            $response['main_menu'] = $data_q;

            // return $response;
            $slider_data = Slider::get_slider_1(3);
            $response['home-slider'] = $slider_data;


            $categories = ProductCategorySelfRel::getAllparentCat();
            $response['categories'] = $categories;

            $fp = fopen('json/landing_json.json', 'w');
            fwrite($fp, \yii\helpers\Json::encode($response));
            fclose($fp);

            return $this->redirect(['/']);
    }

    public function actionCreate_json_page(){
        $response = [];
        $file = 'json/allpages.json';

        if(is_file($file))
            unlink($file);

        $pages_data_list = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>0])->all();

        $i=0;
        foreach($pages_data_list as $pages_data){
            $response[$pages_data->page_slug] = Page::getOne_page($pages_data->page_slug);
            $i++;
        }


        $fp = fopen($file, 'w');
        fwrite($fp, \yii\helpers\Json::encode($response));
        fclose($fp);

        return $this->redirect(['/']);
    }

    /*public function actionCreate_json_project(){

        $project_list_r = Product::find()->all();

        foreach($project_list_r as $project_list ){
            $response = [];

            $fp = fopen('json/project_list.json', 'w');
            fwrite($fp, \yii\helpers\Json::encode($response));
            fclose($fp);  

            $response = \Yii::$app->response;
            $response->headers->set('Content-Type', 'json');
            $response->format = \yii\web\Response::FORMAT_RAW;
            if ( !is_resource($response->stream = fopen('json/project_list.json', 'r')) ) {
               throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
            }        
        }
    }*/

    public function actionCreate_product_list(){
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $product_all_list = Product::get_all_product();

        $response = [];

        $response['product_list'] = $product_all_list;

        $fp = fopen('json/project_list.json', 'w');
        fwrite($fp, \yii\helpers\Json::encode($response));
        fclose($fp);

        return $this->redirect(['/']);
        
    }



    public function actionCreate_all_project_detail(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = Product::get_all_product_with_detail();

        /*$response = [];

        $response['product_list'] = $product_all_list;*/
        /*$data = ProductCategorySelfRel::getAllparentCat();

        $category_data = [];
        $i=0;
        foreach ($data as $key) {
            $category_data[$i] = ProductCategory::getHierarchy_cat_with_slug($key['slug']);

            $i++;
        }*/

        $fp = fopen('json/project_detail.json', 'w');
        fwrite($fp, \yii\helpers\Json::encode($response));
        fclose($fp);
        
        return $this->redirect(['/']);

    }







    /*forms submit*/
















    public function actionIndex()
    {   
        
        

        return $this->render('index'/*,['menu'=>$menu]*/);
    }


 
}
