<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use yii\filters\VerbFilter;
use yii\helpers\Url;

use backend\models\ActivityLog;

/**
 * Site controller
 */
class SetupController extends Controller
{
    public function beforeAction($action){

        $this->enableCsrfValidation = false;
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        if(Yii::$app->params['setup.status']=="Installed"){
            return $this->redirect(['/site/login']);
        }

        return parent::beforeAction($action);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            
        ];
    }


    public function actionIndex(){
        $this->layout = 'login_layout';
        return $this->render('index');
    }

    public function actionStep2(){
        $this->layout = 'login_layout';

        return $this->render('step2');
    }

    public function actionStep3(){
        $this->layout = 'login_layout';

        if (Yii::$app->request->isAjax) {

            $response = [];


            $site_title = $_POST['site_title'];
            $copyright_text = $_POST['copyright_text'];
            $admin_email = $_POST['admin_email'];
            $contact_email = $_POST['contact_email'];
            $facebook = $_POST['facebook'];
            $twitter = $_POST['twitter'];
            $linkedin = $_POST['linkedin'];

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
            

            return json_encode($response);
            
        }


        return $this->render('step3');
    }



    public function actionStep4(){
        $this->layout = 'login_layout';

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

        return $this->render('step4',['themes_array_front'=>$themes_array_front]);
    }



    public function actionActivate_front_theme(){
        if( Yii::$app->request->isAjax ){
            if(isset($_POST['front_theme'])){
                $name = $_POST['front_theme'];
            }else{
                $name = $_POST['back_theme'];
            }
            

            if(!empty($name)){ 

                if(isset($_POST['front_theme'])){
                    $dir = dirname(__FILE__).'/../../frontend/web/themes';
                }else{
                    $dir = dirname(__FILE__).'/../web/themes';
                }

                
                $directories = array_slice(scandir($dir), 2);

                if (in_array($name, $directories)) {
                    $file = dirname(__FILE__).'/../../common/config/params.json';
                    $string = file_get_contents($file);
                    $json_a = json_decode($string, true);
                    
                    if(isset($_POST['front_theme'])){
                        $json_a['frontend.theme'] = $name;
                    }else{
                        $json_a['backend.theme'] = $name;
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
                    $response['msg'] = 'Invalid theme name.';
                }
                

            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error Activating theme.';
            }

            return json_encode($response);
        }
    }



    public function actionStep5(){
        $this->layout = 'login_layout';

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

        return $this->render('step5',['themes_array'=>$themes_array]);
    }




    public function actionStep6(){
        $this->layout = 'login_layout';


        if( Yii::$app->request->isAjax ){
            $status = $_POST['status'];

            if(!empty($status)){ 

                $file = dirname(__FILE__).'/../../common/config/params.json';
                $string = file_get_contents($file);
                $json_a = json_decode($string, true);
                
                $json_a['setup.status'] = $status;

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
                $response['msg'] = 'Setup Successfull.';
                

            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error Activating theme.';
            }

            return json_encode($response);
        }

        return $this->render('step6');
    }

    




}
