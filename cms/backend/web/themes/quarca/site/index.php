<?php
        $this->registerJsFile($this->theme->baseUrl."/vendor/js/required.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/quarca.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/others/underscore/underscore-min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/jqueryui/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/jqueryui/jquery.ui.touch-punch.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/gridstack/gridstack.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
         
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/fittext/jquery.fittext.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.resize.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.tooltip.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.pie.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/charts/flot/jquery.flot.time.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

        $this->registerJsFile($this->theme->baseUrl."/assets/js/init/init.dashboard-new.js", ['depends' => [\yii\web\JqueryAsset::className()]]);  

?>
<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';
use yii\helpers\Url;

require_once( dirname(__FILE__) . '/../../../../web/google-api-php-client-master/src/Google/autoload.php');

        $client = new Google_Client();
        $client->setClientId('253546532038-3fmm49ovaq48j3jkd7cg6s4jflndeqpo.apps.googleusercontent.com');
        $client->setClientSecret('-gP34uZGTMYkQYt7IB1pgNUe');
        $client->setDeveloperKey('AIzaSyAiZog23NbCHJH4DSH-rzqEhb-CAIVNLQU');
        $client->setRedirectUri('http://localhost/cms/administrator');
        $client->setScopes(array('https://www.googleapis.com/auth/analytics'));

    function isLoggedIn($client){

        if (isset($_SESSION['token'])) {
          $client->setAccessToken($_SESSION['token']);

          return true;
        }
     
        return $client->getAccessToken();
    }//authenticate
     
    function login( $code, $client ){     
        $client->authenticate($code);
        $token = $client->getAccessToken();
        /*$token = $client->refreshToken($token);*/
        $_SESSION['token'] = $token;
                 
        return $token;
    }//login
     
    function getLoginUrl($client){
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }//getLoginUrl


    if( isLoggedIn($client) ){
        //$client->setUseObjects(true);
        //echo $_SESSION['token'];
        //$refreshToken = json_decode($_SESSION['token']);
        /*var_dump($refreshToken->access_token);
        $token = $client->refreshToken($refreshToken->access_token);
        $_SESSION['token'] = $token;*/

        $service = new Google_Service_Analytics($client);

        $results_top_pages = $service->data_ga->get(
            'ga:82033170',
            date('Y-m-d',strtotime('-31 days')),
            date('Y-m-d',strtotime('-1 day')),
            'ga:pageviews,ga:users,ga:newUsers,ga:percentNewSessions,ga:sessions,ga:avgSessionDuration,ga:bounceRate,ga:uniquePageviews');
        if(is_array($results_top_pages->getRows())){
            $data = '';
            foreach ($results_top_pages->getRows() as $key) {
                $data = $key;
            }
        }

        $views_country = $service->data_ga->get(
            'ga:82033170',
            date('Y-m-d',strtotime('-31 days')),
            date('Y-m-d',strtotime('-1 day')),
            'ga:pageviews',
            array(
                'dimensions' => 'ga:country',
                'sort' => '-ga:pageviews',
                'max-results' => 7
            ));
        //echo '<pre>';
        //var_dump($views_country);
        if(is_array($views_country->getRows())){
            $data_country = $views_country->getRows();
            /*foreach ($views_country->getRows() as $key1) {
                $data_country = $key1;
            }*/
        }

        echo date('Y-m-d',strtotime('-31 days')).'-----'.date('Y-m-d',strtotime('-1 day'));
    }
    else{
        $url = getLoginUrl($client);
        echo '<div class="col-md-12"><a class="btn btn-sm btn-primary" href="'.$url.'">Plaese Login To Analytics</a></div>';
    }


    if( isset($_GET['code'])){
        $code = $_GET['code'];
        login($code, $client);
        

        \Yii::$app->response->redirect('http://localhost/cms/administrator')->send();
    }
?>

<div class="col-md-12" style="margin-top:15px;">
    <div class="row">
        
        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" style="width:100%;" href="<?= Url::toRoute(['json/get_landing_section']); ?>">Create Landing Json</a>
        </div>

        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" style="width:100%;" href="<?= Url::toRoute(['json/create_json_page']); ?>">Create Page Json</a>
        </div>

        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" style="width:100%;" href="<?= Url::toRoute(['json/create_product_list']); ?>">Create project List Json</a>
        </div>

        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" style="width:100%;" href="<?= Url::toRoute(['json/create_all_project_detail']); ?>">Create project detail Json</a>
        </div>

    </div>
</div>

<?php
    if(isset($data)){
?>

    <div class="drag-drop">
        <div id="widgets-container" class="grid-stack cols-4">
        
            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social twitter">
                            <span class="social-title">Page Views</span>
                            <span class="social-count">
                                <?php
                                    echo $data[0];
                                 ?> 
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social facebook">
                            <span class="social-title">Users</span>
                            <span class="social-count">
                                <?php
                                    echo $data[1];
                                 ?>  
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social youtube">
                            <span class="social-title">New Users</span>
                            <span class="social-count">
                                <?php
                                    echo $data[2];
                                 ?>  
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social linkedin">
                            <span class="social-title">New Sessions</span>
                            <span class="social-count">
                                <?php
                                    echo round($data[3],2);
                                 ?>
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->









            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social twitter">
                            <span class="social-title">Sessions</span>
                            <span class="social-count">
                                <?php
                                    echo $data[4];
                                 ?> 
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social facebook">
                            <span class="social-title">Average Session Duration</span>
                            <span class="social-count">
                                <?php
                                    echo round($data[5],2);
                                 ?>  
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social youtube">
                            <span class="social-title">Bounce Rate</span>
                            <span class="social-count">
                                <?php
                                    echo round($data[6],2);
                                 ?>  
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->

            <div class="grid-stack-item"
                data-gs-no-resize="yes"
                data-gs-auto-position="yes"
                data-gs-width="1" data-gs-height="1">
                <div class="grid-stack-item-content">
                
                <div class="widget social-stats">
                    <span class="drag fa"></span>
                    <div class="widget-content">
                        <div class="item social linkedin">
                            <span class="social-title">Unique Page Views</span>
                            <span class="social-count">
                                <?php
                                    echo $data[7];
                                 ?>
                                 <small></small></span>
                            <span class="social-icon"><i class="fa fa-twitter"></i></span>
                        </div>
                    </div><!-- widget-content -->
                </div><!-- widget -->
                
                </div><!-- grid-stack-item-content -->
            </div><!-- /grid-stack-item -->


            <div class="grid-stack-item white-handle" 
                    data-gs-auto-position="yes"
                    data-gs-width="2" data-gs-height="2"
                    data-gs-min-width="1" data-gs-min-height="3"
                    data-gs-max-width="4" data-gs-max-height="3">
                    <div class="grid-stack-item-content">
                    
                    <div class="widget">
                        <span class="drag fa"></span>
                        <div class="widget-content">
                            <div class="pane equal" style="padding:0;">
                                <h2 style="margin-bottom:10px;"><span>Visitors By Country</span></h2>
                                <div class="filter-table" id="users2">
                                
                                    <table class="table table-bordered no-margin-bottom">
                                        <thead>
                                        <tr>
                                            <th class="sort" data-sort="Country">Country</th>
                                            <th class="sort" data-sort="Visitors">Visitors</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody class="list">
                                            <?php if(!empty($data_country))
                                                {       //echo '<pre>';
                                                        //var_dump($data_country);
                                                    foreach ($data_country as $key) {


                                                        echo '<tr>';
                                                            
                                                            echo '<td class="Country">'.$key[0].'</td>';
                                                            echo '<td class="Visitors">'.$key[1].'</td>';
                                                            
                                                        echo '</tr>';
                                                    }
                                                } 
                                            ?>
                                        </tbody>
                                    </table>
                                </div><!-- /filter-table -->
                                
                            </div><!-- pane -->
                        </div>
                    </div>
                    
                    </div>
                </div><!-- /grid-stack-item -->


                <div class="grid-stack-item"
                     data-gs-no-resize="yes"
                    data-gs-auto-position="yes"
                    data-gs-width="1" data-gs-height="4">
                    <div class="grid-stack-item-content">
                    
                    <div class="widget widget-new-returning-visitors">
                        <span class="drag fa"></span>
                        <div class="widget-content">

                        <div class="flot-chart">
                            <div id="social-stats" class="flot pie"></div>
                        </div><!-- flot-chart -->
                        
                        </div><!-- widget-content -->
                    </div><!-- widget -->
                    
                    </div><!-- grid-stack-item-content -->
                </div><!-- /grid-stack-item -->
        
        
        </div><!-- /grid-stack -->
    </div><!-- /drag-drop -->

<?php } ?>