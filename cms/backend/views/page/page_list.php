<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages List';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>







<div class="col-md-12">
    <?php echo Html::a('Create Page', ['create'], ['class' => 'btn btn-primary btn-sm pull-right']); ?>
</div>
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
                        echo '<td><a href="'.Url::toRoute(['page/list_view', 'id' => $key->id]).'">'.$key->page_title.' ( '.$key->child_count.' )</a></td>';
                    }
                    echo '<td>'.date_format(date_create($key->created_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->created_at), 'g:i A').'</td>';
                    echo '<td>'.date_format(date_create($key->updated_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->updated_at), 'g:i A').'</td>';
                    echo '<td>'.$key->createUserName.'</td>';
                    echo '<td>'.$key->updateUserName.'</td>';
                    echo '<td>';
                        echo Html::a('View', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                        echo Html::a('Update', ['update', 'id' => $key->id], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-left:10px;',]);
                        echo Html::a('Archive', ['archive', 'id' => $key->id], [
                                'class' => 'btn btn-danger btn-xs archive_btn',
                                'style' => 'margin-left:10px;',
                            ]);
                    echo '</td>';
                echo '</tr>';


				

			}
            echo '</table>';
		} 
	?>

</div>

<?php

    $this->registerJs("
                    $(document).delegate('.archive_btn', 'click', function() { 
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
    ", yii\web\View::POS_READY, 'page_archive');

?>