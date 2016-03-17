<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use yii\filters\VerbFilter;

use backend\models\ActivityLog;
use backend\models\Contact_form;

/**
 * Site controller
 */
class SiteController extends Controller
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
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionSetup(){
        echo 'Setup Wizard';
    }

    public function actionTimeline(){
        $model = (new \yii\db\Query())
                ->select(['*'])
                ->from('activity_log')
                ->orderBy('id desc')
                ->all(); 
        
        return $this->render('timeline',['model'=>$model]);

    }

    public function actionSearch(){
         
        if (Yii::$app->request->isAjax) {
            $term = $_POST['term'];

            $pages = (new \yii\db\Query())
                ->select(['id', 'page_title', 'updated_at'])
                ->from('page')
                ->where(['like','page_title',$term])
                ->all(); 


            $product_categories = (new \yii\db\Query())
                ->select(['id', 'cat_title', 'updated_at'])
                ->from('product_category')
                ->where(['like','cat_title',$term])
                ->all();

            $products = (new \yii\db\Query())
                ->select(['id', 'title', 'updated_at'])
                ->from('product')
                ->where(['like','title',$term])
                ->all();
            

            $view = $this->renderAjax('search_view', [
                                'pages' => $pages,
                                'product_categories' => $product_categories,
                                'products' => $products
                            ]);

            $response = '';
            $response['view'] = $view;

            return json_encode($response);
        }
    }

    public function actionAccesscontrol(){
        return $this->render('accesscontrol');
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
        ];
    }

    public function actionIndex()
    {
        

        return $this->render('index');
    }

    public function actionLock_screen($previous){
        $this->layout='login_layout';

        if(isset(Yii::$app->user->identity->username)){
            // save current username    
            $username = Yii::$app->user->identity->username;
            $image = \Yii::$app->session->get('user.image');
            // force logout     
            Yii::$app->user->logout();
            // render form lockscreen
            $model = new LoginForm(); 
            $model->username = $username;    //set default value 
            return $this->render('lockScreen', [
                'model' => $model,
                'previous' => $previous,
                'image' => $image
            ]);  
        }
        else{
            return $this->redirect(['login']);
        }
    }

    public function actionLogin($previous="")
    {
        $this->layout='login_layout';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $timestamp = date("Y-m-d h:i:s");
            \Yii::$app->session->set('user.username',$model->username);
            \Yii::$app->session->set('user.last_access',$timestamp);
            \Yii::$app->session->set('user.image',$model->User->image);

            $user = User::find()->where(['id' => $model->User->id])->one();
            $user->last_access = $timestamp;
            $user->save();

            if(!empty($previous)){
                return $this->redirect($previous);
            }
            else{
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    
    
    public function actionContact(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];

        $data =  json_decode(utf8_encode(file_get_contents("php://input")), false);

        $model = new Contact_form();
        $model->name = $data->name;
        $model->email = $data->email;
        $model->message = $data->message;
        $model->mobile = $data->mobile;
        $model->interest = $data->interest;

        $valid = $model->validate();
        if($valid){
            $subject="Tropical Homes Ltd - Contact";
            $message_text="Name: ".$model->name."<br/>".
                          "Email: ".$model->email."<br/>".
                          "Mobile: ".$model->mobile."<br/>".
                          "Interest: ".$model->interest."<br/>".
                          "Message: ".$model->message;

            try{
                $message = Yii::$app->mailer->compose();

                $message->setFrom($model->email);
                $message->setTo('tropicalhomes1996@gmail.com');

                $message->setSubject($subject);
                $message->setHtmlBody($message_text);

                if($message->send()){

                    $response['result'] = 1;
                    $response['msg'] = 'Thank you for your interest in Tropical homes.';
                }
            }catch(Exception $e){
                $response['result'] = 0;
                $response['msg'] = $e;
            }
        }else{
            $response['result'] = 0;
            $response['msg'] = Html::errorSummary($model);
        }
       
        return $response;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
