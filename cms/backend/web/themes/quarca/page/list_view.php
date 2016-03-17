<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadUI;
use newerton\jcrop\jCrop;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->page_title;
$this->params['breadcrumbs'][] = ['label' => 'Page list', 'url' => ['list']];
foreach ($breadcumb as $key) {
            $this->params['breadcrumbs'][] = ['label' => $key['title'], 'url' => ['list_view', 'id' => $key['id']]];
        }

$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::base()."/files/custom_test.js", ['depends' => [\yii\web\JqueryAsset::className()]]);



?>

<div class="col-md-12">
    <?php echo Html::a('Create Page', ['create'], ['class' => 'btn btn-primary btn-sm pull-right']); ?>
</div>
<div class="col-md-12">
    
    
    <?php if(!empty($child_pages))
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
            foreach ($child_pages as $key) {
                

                echo '<tr>';
                    if($key->child_count==0){
                        echo '<td>'.$key->page_title.'</td>';
                    }else{
                        echo '<td><a href="'.Url::toRoute(['page/list_view', 'id' => $key->id]).'">'.$key->page_title.' ( '.$key->child_count.' )</a></td>';
                    }
                    echo '<td>'.$key->created_at.'</td>';
                    echo '<td>'.$key->updated_at.'</td>';
                    echo '<td>'.$key->createUserName.'</td>';
                    echo '<td>'.$key->updateUserName.'</td>';
                    echo '<td>';
                        echo Html::a('View', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                        echo Html::a('Update', ['update', 'id' => $key->id], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;',]);
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


<div class="page-view">

   <!--  <h1><?= Html::encode($this->title) ?></h1> -->

   <!--  <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?php /*DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'page_title',
            'page_slug',
            'short_desc',
            'meta_key',
            'meta_desc',
            'date',
            'page_desc:ntext',
            'status',
            'page_type',
        ],
    ])*/ ?>

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