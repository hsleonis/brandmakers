<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-index">
    <div class="pane" style="float:left; width:100%;">
        <div class="col-md-12">
            <div class="filter-table" id="table2" style="margin-bottom:30px;">
                <ul class="pagination pagination2"></ul>
                <table class="table table-bordered no-margin-bottom">
                    <thead>
                    <tr>
                        <th class="sort col-md-2" data-sort="Name"  width="50%">Name</th>
                        <th class="sort col-md-2" data-sort="Email">Email</th>
                        <th class="sort col-md-5" data-sort="Comment">Comment</th>
                        <th class="col-md-3">Actions</th>
                    </tr>
                    </thead>
                    
                    <tbody class="list">
                        <?php if(!empty($data))
                            {
                                foreach ($data as $key) {
                                    
                                    echo '<tr id="comment_row_'.$key->id.'">';
                                        echo '<td class="Name  col-md-2">'.$key->name.'</td>';
                                        echo '<td class="Email col-md-2" style="overflow:hidden;">'.$key->email.'</td>';
                                        echo '<td class="Comment col-md-5">'.$key->comment.'</td>';
                                        echo '<td class="col-md-3">';
                                            echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                                            echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key->id], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;']);
                                            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['deleteapproved', 'id' => $key->id], ['class' => 'btn btn-danger btn-xs archive_btn','style' => 'margin-left:10px;','data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ]]);
                                            echo Html::a('Unapprove', ['unapprove', 'id' => $key->id], ['class' => 'btn btn-danger btn-xs unapprove_btn','style' => 'margin-left:10px;',]);
                                            
                                        echo '</td>';
                                    echo '</tr>';

                                }
                            } else{
                                echo '<tr><td colspan="3">No results found.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div><!-- /filter-table -->
            

        </div>

    </div>
</div>



<?php
    
    $this->registerJs("
                    $(document).delegate('.unapprove_btn', 'click', function() { 
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
                                     $('#comment_row_'+data.files.id).remove();
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'unapprove');




    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.pagination.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

    $this->registerJs("
        
        var paginationTopOptions2 = {
            name: 'pagination1',
            paginationClass: 'pagination2'
          };
        
        var options2 = {
            valueNames: [ 'Name','Email' ,'Comment'],
            page: 20,
            plugins: [ ListPagination(paginationTopOptions2) ],
        };
        
        var userList = new List('table2', options2);

    ", yii\web\View::POS_READY, 'table1df');



?>