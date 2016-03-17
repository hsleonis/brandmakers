<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Archived Pages';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="col-md-12">
    <div class="row">
        <div class="pane">
            <div class="filter-table" id="users2">
                <table class="table table-bordered no-margin-bottom">
                    <thead>
                        <tr>
                            <th class="sort" data-sort="title">Page Title</th>
                            <th class="sort" data-sort="create_time">Create Time</th>
                            <th class="sort" data-sort="updated_time">Updated Time</th>
                            <th class="sort" data-sort="created_by">Created By</th>
                            <th class="sort" data-sort="updated_by">Updated By</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                
                    <tbody class="list">

                        <?php if(!empty($pages))
                            {
                                foreach ($pages as $key) {

                                    echo '<tr id="page_row_'.$key->id.'">';
                                        if($key->child_count==0){
                                            echo '<td class="title">'.$key->page_title.'</td>';
                                        }else{
                                            echo '<td class="title"><a href="'.Url::toRoute(['page/archive_list', 'id' => $key->id]).'">'.$key->page_title.' ( '.$key->child_count.' )</a></td>';
                                        }
                                        echo '<td class="create_time">'.date_format(date_create($key->created_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->created_at), 'g:i A').'</td>';
                                        echo '<td class="updated_time">'.date_format(date_create($key->updated_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->updated_at), 'g:i A').'</td>';
                                        echo '<td class="created_by">'.$key->createUserName.'</td>';
                                        echo '<td class="updated_by">'.$key->updateUserName.'</td>';
                                        echo '<td>';
                                            echo Html::a('View', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                                        if(!isset($_GET['id'])){
                                            echo Html::a('Restore', ['restore_page', 'id' => $key->id], ['class' => 'btn btn-success btn-xs restore_page_btn', 'style' => 'margin-left:10px;']);
                                        }
                                        if(!isset($_GET['id'])){
                                            echo Html::a('Delete', ['delete_page', 'id' => $key->id], ['class' => 'btn btn-success btn-xs restore_page_btn', 'style' => 'margin-left:10px;']);
                                        }
                                        echo '</td>';
                                    echo '</tr>';

                                }
                            } 
                        ?>

                    </tbody>
                </table>
            </div>
        	
        </div>
    </div>
</div>

<?php
    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.pagination.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

    $this->registerJs("
                    $(document).delegate('.restore_page_btn', 'click', function() { 
                        var url = $(this).attr('href');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : url,
                            data: {},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     alertify.log(data.files.msg, 'success', 5000);
                                     $('#page_row_'+data.files.id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'page_restore');

    $this->registerJs("
        var options = {
        valueNames: [ 'title','create_time', 'updated_time', 'created_by', 'updated_by' ]
        };
        
        var userList = new List('users2', options);

    ", yii\web\View::POS_END, 'page_sort');

?>