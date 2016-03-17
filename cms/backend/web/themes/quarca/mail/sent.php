<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use backend\models\Mail;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sent Mails';
$this->params['breadcrumbs'][] = $this->title;




/*echo '<pre>';
var_dump($data);*/
?>
<div class="col-md-2">
        <div class="">
            <div class="pane" style="background:none; padding:0;">
                <p>
                    <?= Html::a('Compose', ['compose'], ['class' => 'btn btn-success','style'=>'width:100%;']) ?>
                </p>
                <ul class="list-unstyled mailbox-nav">
                    <li class="<?php echo (Yii::$app->controller->action->id=='index')?'active':''; ?>" ><a href="<?= Url::toRoute(['/mail/index']); ?>"><i class="fa fa-inbox"></i>Inbox <span class="badge badge-success pull-right">4</span></a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='sent')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/sent']); ?>"><i class="fa fa-sign-out"></i>Sent</a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='draft')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/draft']); ?>"><i class="fa fa-file-text-o"></i>Draft</a></li>
                    <li class="<?php echo (Yii::$app->controller->action->id=='trash')?'active':''; ?>"><a href="<?= Url::toRoute(['/mail/trash']); ?>"><i class="fa fa-trash"></i>Trash</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-10">
        <div class="">
            <div class="pane">
                <table class="table no-margin-bottom">
                    
                    <tbody class="list">
                        <tr>
                            <td colspan="4">
                                <input type="checkbox" class="check_all" name="check_all" style="float:left;">
                                <div class="btn_panel_mail text-right">
                                    <button class="btn btn-default btn-icon btn-sm trash_btn" type="button">
                                        <span class="icon"><i class="fa fa-trash"></i></span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <?php
                            foreach ($data as $key) {
                                $address_array = explode(',', $key->mailto);
                                $final_address = explode('@',reset($address_array));
                        ?>

                            <tr id="mail_row_<?=$key->id;?>">
                                <td><input type="checkbox" class="checkbox" name="check" value="<?= $key->id; ?>"></td>
                                <td><?php 
                                        echo '<a href="'.Url::toRoute(['/mail/v','id'=>$key->id]).'">';
                                            echo Mail::limit_str(15,$final_address[0]); 
                                            if(count($address_array)>1){
                                                echo ' ('.(count($address_array)-1).')';
                                            }
                                        echo '</a>';
                                    ?>
                                </td>
                                <td><?= Mail::limit_str(80,'<strong>'.$key->subject.'</strong> - '.strip_tags($key->message)); ?></td>
                                <td><?= date_format(date_create($key->create_time), "F j, Y, g:i a"); ?></td>
                            </tr>

                        <?php
                            }
                        ?>
                        


                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php

    $this->registerJs("
                    $(document).delegate('.trash_btn', 'click', function() { 
                        
                        var checkboxValues = [];
                        $('.checkbox:checked').map(function() {
                            checkboxValues.push($(this).val());
                        });

                        $.ajax({
                                url: '".Url::toRoute(['/mail/trash_item'])."',
                                type: 'post',
                                data: {data:checkboxValues},
                                beforeSend : function( request ){
                                    
                                },
                                success: function(data) {
                                    dt = jQuery.parseJSON(data);

                                    if(dt.result=='success'){
                                        $.each(checkboxValues,function(key, value){
                                            $('#mail_row_'+value).remove();
                                        });
                                    }else{
                                        
                                        //alertify.log(dt.files, 'error', 5000);
                                    }

                                }
                        });
                    });
    ", yii\web\View::POS_END, 'trash');

    $this->registerJs("
            $('.check_all').click(function() {
                if($(this).is(':checked')) {
                    $('.checkbox').each(function() { 
                        this.checked = true;              
                    });
                } else {
                    $('.checkbox').each(function() { 
                        this.checked = false;              
                    });
                }
            });
    ", yii\web\View::POS_END, 'check_uncheck_all');

?>