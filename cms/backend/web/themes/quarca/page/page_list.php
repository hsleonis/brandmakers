<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!empty($model)){
    $this->title = $model->page_title;
}else{
    $this->title = '';
}

$this->params['breadcrumbs'][] = ['label' => 'Page list', 'url' => ['list']];

if(!empty($breadcumb)){
    foreach ($breadcumb as $key) {
        $this->params['breadcrumbs'][] = ['label' => $key['title'], 'url' => ['list_view', 'id' => $key['id']]];
    }
}


$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile(Url::base()."/files/html.sortable_product_image.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
?>



<div class="pane equal" style="float:left; width:100%;">
    <h2><?php echo Html::a('Create Page', ['create'], ['class' => 'btn btn-primary btn-sm']); ?></h2>
    <div class="filter-table" id="users2">


        <ul class="page_list_ul">
            <li>
                <div class="col-md-6">
                    <strong>Page Title</strong>
                </div>
                <div class="col-md-3">
                    <strong>Updated Time</strong>
                </div>
                <div class="col-md-3">
                    <strong>Actions</strong>
                </div>
            </li>
        </ul>

        <ul class="sortable grid page_list_ul">

            <?php if(!empty($pages))
                    {
                        foreach ($pages as $key) {
            ?>

                <li data-id="<?= $key->id; ?>" id="page_row_<?= $key->id; ?>">
                    <div class="col-md-6">
                        <?php
                            if($key->child_count==0){
                                echo '<td class="title">'.$key->page_title.'</td>';
                            }else{
                                echo '<td class="title"><a href="'.Url::toRoute(['page/list', 'id' => $key->id]).'">'.$key->page_title.' ( '.$key->child_count.' )</a></td>';
                            }
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                            echo date_format(date_create($key->updated_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key->updated_at), 'g:i A');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                                echo Html::a('View', ['view', 'id' => $key->id], ['class' => 'btn btn-primary btn-xs']);
                                echo Html::a('Update', ['update', 'id' => $key->id], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;']);
                                echo Html::a('Archive', ['archive', 'id' => $key->id], [
                                        'class' => 'btn btn-danger btn-xs archive_btn',
                                        'style' => 'margin-left:10px;',
                                    ]);
                        ?>
                    </div>
                </li>

            <?php
                }
            }
            ?>
        </ul>
    </div><!-- /filter-table -->
    
</div><!-- pane -->



<?php

    $this->registerJs("
        
        $('.sortable').sortable();

        $('.sortable').sortable().bind('sortupdate', function(e, ui) {
            sort()
        })

        function sort(){
            var data = [];
                $('.sortable li').each(function( key, value ) {
                    data.push($(this).attr('data-id'));
                });


                $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : '".Url::toRoute('page/save_page_sort_order')."',
                    data: {data:data},
                    beforeSend : function( request ){
                       
                        /*$('.post_sort_order_wrap').addClass('loader');
                        $('.post_sort_order').hide();*/
                    },
                    success : function( data )
                        { 
                            /*if(data.result=='success'){
                                //alertify.log(data.msg, 'success', 5000);
                                $('.list_of_post').html(data.post_list);


                                $('.post_sort').sortable();
                                $('.post_sort').sortable().bind('sortupdate', function(e, ui) {
                                    sort();
                                    return false;
                                });

                            }else{
                                alertify.log(data.msg, 'error', 5000);
                            }
                            $('.post_sort_order_wrap').removeClass('loader');
                            $('.post_sort_order').show();*/
                        }
                })
        }
    ", yii\web\View::POS_READY, 'page_sorting');

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