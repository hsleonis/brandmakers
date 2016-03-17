<?php

namespace backend\controllers;

use Yii;
use backend\models\Settings;
use backend\models\SettingsSearch;
use backend\models\ProductCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $themes_array = array();
        

        $dir = dirname(__FILE__).'/../web/themes';
        
        $directories = array_slice(scandir($dir), 2);
        foreach ($directories as $key => $value) {

            if (is_dir($dir.'/'.$value)) {
                $filename = '';
                $files = '';
                $images = '';


                $dh  = opendir($dir.'/'.$value);

                while (false !== ($filename = readdir($dh))) {
                    $files[] = $filename;
                }
                $images=preg_grep ('/\.jpg$/i', $files);

                
                if(empty($images)){
                    $img = Url::to('@web/image/default.jpg', true);
                }else{
                    $img = Url::to('@web/themes/'.$value.'/'.reset($images), true);
                }

                array_push($themes_array, array('name'=>$value, 
                                                'image'=>$img,
                                                ));
            }
        }

        $themes_array_front = array();
        $dir_front = dirname(__FILE__).'/../../frontend/web/themes';
        
        $directories_front = array_slice(scandir($dir_front), 2);
        foreach ($directories_front as $key => $value) {

            if (is_dir($dir_front.'/'.$value)) {
                $filename = '';
                $files = '';
                $images = '';


                $dh  = opendir($dir_front.'/'.$value);

                while (false !== ($filename = readdir($dh))) {
                    $files[] = $filename;
                }
                $images=preg_grep ('/\.jpg$/i', $files);

                
                if(empty($images)){
                    $img = Url::to('@web/image/default.jpg', true);
                }else{
                    $img = Url::to(\Yii::$app->urlManagerFrontEnd->baseUrl.'/themes/'.$value.'/'.reset($images), true);
                }

                array_push($themes_array_front, array('name'=>$value, 
                                                'image'=>$img,
                                                ));
            }
        }



        $editor_array = array();
        $dir_editor = dirname(__FILE__).'/../web/ckeditor/config';
        
        $filename = '';
        $configs = '';

        $dh  = opendir($dir_editor);

        while (false !== ($filename = readdir($dh))) {
            $configs[] = $filename;
        }
        
        

        $id =1;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('index', [
                'model' => $model, 'themes_array'=>$themes_array,'themes_array_front'=>$themes_array_front,
                'configs'=>array_slice($configs,2)
            ]);
        }
    }

    public function actionActivate_theme(){
        if( Yii::$app->request->isAjax ){
            $name = $_POST['name'];
            $type = $_POST['type'];

            if(!empty($name)){ 

                    $file = dirname(__FILE__).'/../../common/config/params.json';
                    $string = file_get_contents($file);
                    $json_a = json_decode($string, true);

                    if($type=='back'){
                        $json_a['backend.theme'] = $name;
                    }else{
                        $json_a['frontend.theme'] = $name;
                    }
                    

                    $new_string = "<?php return [\n";
                    $i=0;
                    foreach ($json_a as $key => $value) {
                        if($i==0){
                            $new_string .= "'".$key."' => '".$value."'";
                        }else{
                            $new_string .= ",\n'".$key."' => '".$value."'";
                        }
                        $i++;
                    }
                    $new_string .= "\n];";

                    $file_php = dirname(__FILE__).'/../../common/config/params.php';
                    $fd_php=fopen($file_php,"w");
                    fwrite($fd_php, $new_string);
                    fclose($fd_php);


                    $json_a_new = json_encode($json_a, true);
                    $fd_json=fopen($file,"w");
                    fwrite($fd_json, $json_a_new);
                    fclose($fd_json);

                    $response['result'] = 'success';
                    $response['msg'] = 'Theme Activated.';
            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error Activating theme.';
            }

            return json_encode($response);
        }
    }

    public function actionSave_settings(){
        if( Yii::$app->request->isAjax ){
            $admin_email = $_POST['admin_email'];
            $contact_email = $_POST['contact_email'];
            $copyright_text = $_POST['copyright_text'];
            $site_title = $_POST['site_title'];
            $facebook = $_POST['facebook'];
            $twitter = $_POST['twitter'];
            $linkedin = $_POST['linkedin'];
            $editor = $_POST['editor'];

            if(!empty($admin_email)){ 

                $file = dirname(__FILE__).'/../../common/config/params.json';
                $string = file_get_contents($file);
                $json_a = json_decode($string, true);
                
                $json_a['admin_email'] = $admin_email;
                $json_a['contact_email'] = $contact_email;
                $json_a['copyright_text'] = $copyright_text;
                $json_a['site_title'] = $site_title;
                $json_a['facebook'] = $facebook;
                $json_a['twitter'] = $twitter;
                $json_a['linkedin'] = $linkedin;
                $json_a['editor'] = $editor;
                


                $new_string = "<?php return [\n";
                $i=0;
                foreach ($json_a as $key => $value) {
                    if($i==0){
                        $new_string .= "'".$key."' => '".$value."'";
                    }else{
                        $new_string .= ",\n'".$key."' => '".$value."'";
                    }
                    $i++;
                }
                $new_string .= "\n];";


                $file_php = dirname(__FILE__).'/../../common/config/params.php';
                $fd_php=fopen($file_php,"w");
                fwrite($fd_php, $new_string);
                fclose($fd_php);


                $json_a_new = json_encode($json_a, true);
                $fd_json=fopen($file,"w");
                fwrite($fd_json, $json_a_new);
                fclose($fd_json);

                $response['result'] = 'success';
                $response['msg'] = 'Settings Saved.';

            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving settings.';
            }

            return json_encode($response);
        }
    }

    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionTabular_input()
    {
            $model = new ProductCategory();
            $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pagesize' => 5
                ]
            ]);
            $models = $dataProvider->getModels();

        
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['ProductCategory']) && isset($_POST['ProductCategory']['cat_create']) ) {
                $model = new ProductCategory();
                $model->attributes = $_POST['ProductCategory'];
            
                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';

                    $model_uu = new ProductCategory();
                    $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pagesize' => 5
                        ]
                    ]);
                    $models = $dataProvider->getModels();
                    $response['post_list'] = $this->renderAjax('ajax_cont', ['dataProvider'=>$dataProvider,'model'=>$model_uu]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            }
            else if (ProductCategory::loadMultiple($models, Yii::$app->request->post()) && ProductCategory::validateMultiple($models)) {
                $count = 0;
                foreach ($models as $index => $model) {
                    // populate and save records for each model
                    if ($model->save()) {
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
                $response['files'] = "Processed {$count} records successfully.";
                $response['result'] = 'success';

                return json_encode($response);
            } 
        }

        

        return $this->render('tabular_input',['dataProvider'=>$dataProvider,'model'=>$model]);

    }



    public function actionMigrate(){
        /*$db = new yii\db\Connection([
            'dsn' => 'mysql:host=localhost;dbname=cms',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]);

        $sql = "CREATE TABLE shimul (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL
                )";
        
        

        $db->createCommand($sql)->execute();*/
        /*$file = dirname(__FILE__).'/../../common/config/params.php';

        $string = '';

        $newdata = "<?php return [";

                            $newdata .= "'adminEmail' => '".Yii::$app->params['adminEmail']."',";
                            $newdata .= "'supportEmail' => '".Yii::$app->params['supportEmail']."',";
                            $newdata .= "'user.passwordResetTokenExpire' => 3600";

                        $newdata .= "];
                            ";
                    $fd=fopen($file,"w");

                    fwrite($fd, $newdata);
                    fclose($fd);


        $fd=fopen($file,"r");
        print_r(file($file));*/

        $file = dirname(__FILE__).'/../../common/config/params.json';
        $string = file_get_contents($file);
        $json_a = json_decode($string, true);
        $json_a['backend.theme'] = 'basic';

        $new_string = "<?php return [\n";
        $i=0;
        foreach ($json_a as $key => $value) {
            if($i==0){
                $new_string .= "'".$key."' => '".$value."'";
            }else{
                $new_string .= ",\n'".$key."' => '".$value."'";
            }
            $i++;
        }
        $new_string .= "\n];";

        $file_php = dirname(__FILE__).'/../../common/config/params.php';
        $fd_php=fopen($file_php,"w");
        fwrite($fd_php, $new_string);
        fclose($fd_php);


        $json_a_new = json_encode($json_a, true);
        $fd_json=fopen($file,"w");
        fwrite($fd_json, $json_a_new);
        fclose($fd_json);

        echo "<pre>";
        var_dump($json_a);
    }


    /**
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Settings model.
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
     * Deletes an existing Settings model.
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
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
