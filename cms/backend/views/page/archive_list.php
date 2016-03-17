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
	<?php if(!empty($pages))
		{
            echo '<table class="table table-striped" style="margin-top:20px;">';
                echo '<tr>';
                    echo '<th>Page Title</th>';
                    echo '<th>Create Time</th>';
                    echo '<th>Updated Time</th>';
                    echo '<th>Created By</th>';
                    echo '<th>Updated By</th>';
                    echo '<th>Actions</th>';
                echo '</tr>';
			foreach ($pages as $key) {
				

                echo '<tr id="page_row_'.$key->id.'">';
                    if($key->child_count==0){
                        echo '<td>'.$key->page_title.'</td>';
                    }else{
                        echo '<td><a href="'.Url::toRoute(['page/archive_list', 'id' => $key->id]).'">'.$key->page_title.' ( '.$key->child_count.' )</a></td>';
                    }
                    echo '<td>'.date_format(date_create($key->created_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->created_at), 'g:i A').'</td>';
                    echo '<td>'.date_format(date_create($key->updated_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->updated_at), 'g:i A').'</td>';
                    echo '<td>'.$key->createUserName.'</td>';
                    echo '<td>'.$key->updateUserName.'</td>';
                    echo '<td>';
                        echo Html::a('View', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                    if(!isset($_GET['id'])){
                        echo Html::a('Restore', ['restore_page', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs restore_page_btn']);
                    }
                    echo '</td>';
                echo '</tr>';


				

			}
            echo '</table>';
		} 
	?>

</div>

<?php

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

?>