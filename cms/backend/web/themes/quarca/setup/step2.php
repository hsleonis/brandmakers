<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Setting Database Connection';

?>

<?php 

                $errors = '';
                $host = '';
                $database = '';
                $username = '';
                $password = '';
                $url = '';
                
                if(isset($_POST['submit']))
                {   
                    $host = $_POST['host'];
                    $database = $_POST['database'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    

                    if($host=='')
                    {
                        $errors .= "Host is a required field.<br/>"; 
                    }
                    if(empty($database))
                    {
                        $errors .= "Database is a required field.<br/> ";
                    }
                    if(empty($username))
                    {
                        $errors .= "Username is a required field. ";
                    }
                    
                    if(empty($errors))
                    {
                       try{
                            $db = new yii\db\Connection([
                                'dsn' => 'mysql:host='.$host.';dbname='.$database,
                                'username' => $username,
                                'password' => $password,
                                'charset' => 'utf8',
                            ]);

                            $count = $db->createCommand('SHOW TABLES FROM '.$database)
                                     ->execute();


                            $file_php = dirname(__FILE__).'/../../../../../common/config/main-local.php';
                            $new_string = "<?php
                                            \nreturn [
                                                \n'components' => [
                                                    \n'db' => [
                                                        \n'class' => 'yii\db\Connection',";

                            $new_string .= "'dsn' => 'mysql:host=".$host.";dbname=".$database."',";
                            $new_string .= "'username' => '".$username."',";
                            $new_string .= "'password' => '".$password."',";
                            $new_string .= "'charset' => 'utf8'";

                            $new_string .= "\n],
                                                \n'mailer' => [
                                                    \n'class' => 'yii\swiftmailer\Mailer',
                                                    \n'viewPath' => '@common/mail',
                                                    \n'useFileTransport' => true,
                                                \n],
                                            \n],
                                        \n];
                                    \n";

                            $fd_php=fopen($file_php,"w");
                            fwrite($fd_php, $new_string);
                            fclose($fd_php);
                            

                            $url = Url::toRoute('step3',true);

                        }
                        catch(Exception $e){
                            //echo $e;
                            $errors .= "Database Connection failed. Try again. ";
                        }
                    }else{
                        //echo $errors;
                    }
                }
                
    ?>
<script type="text/javascript">
    var url = "<?php echo $url; ?>";
    if(url!=''){
        window.location.href = url;
    }
</script>
<style type="text/css">
    
    .loader{
        background-position: left;
        min-height: 65px;
    }
    .action{
        display: none;
    }
    .box_slide_down{
        display: none;
    }
</style>
<div class="site-index">


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 box_slide_down" style="margin-top:100px;">
                <div class="pane" style="float:left;">
                    <h2><span>Setting Database Connection</span></h2>

                    <div style="" aria-expanded="true" id="div-1" class="body full-screen-box collapse in">

                        <div class="tags-form">
                            <?php

                                if(!empty($errors)){
                                    echo '<div role="alert" class="alert alert-danger">';
                                      echo '<span class="icon"><i class="fa fa-times fa-fw fa-2x"></i></span>';
                                      echo $errors;
                                    echo '</div>';
                                }

                            ?>
                            <form action="" id="mainform" method="POST" name="mainform" class="contact" >
                                <div class="settings-form">
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Host Address</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="host" value="<?= $host; ?>" name="host" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Database</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="database" value="<?= $database; ?>" name="database" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Username</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="username" value="<?= $username; ?>" name="username" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Password</label>
                                        <div class="col-lg-8">
                                          <input type="text" id="password" value="<?= $password; ?>" name="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="submit" name="submit" value="submit" class="btn btn-sm btn-primary pull-right">
                                    </div>
                                </div>
                            </form>

                            
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>

<?php

    $this->registerJs("
                    $('.box_slide_down').slideDown('slow');
    ", yii\web\View::POS_READY, 'box_slide_down');

?>