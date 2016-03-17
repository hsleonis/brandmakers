<?php

use yii\helpers\Html;

?>

<h4>Pages</h4>
<div class="col-md-12">
    <div class="filter-table" id="table1" style="margin-bottom:30px;">
    <ul class="pagination pagination1"></ul>
        <table class="table table-bordered no-margin-bottom">
            <thead>
            <tr>
                <th class="sort" data-sort="title"  width="50%">Page Title</th>
                <th class="sort" data-sort="last_updated">Last Updated</th>
                <th class="sort">Actions</th>
            </tr>
            </thead>
            
            <tbody class="list">
                <?php if(!empty($pages))
                    {
                        foreach ($pages as $key) {
                            
                            echo '<tr>';
                                echo '<td class="title">'.$key['page_title'].'</td>';
                                echo '<td class="last_updated">'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                                echo '<td>';
                                    echo Html::a('View', ['/page/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                                    echo Html::a('Update', ['/page/update', 'id' => $key['id']], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;',]);
                                    
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


<h4>Product Categories</h4>
<div class="col-md-12">
    <div class="filter-table" id="table2" style="margin-bottom:30px;">
        <ul class="pagination pagination2"></ul>
        <table class="table table-bordered no-margin-bottom">
            <thead>
            <tr>
                <th class="sort" data-sort="title"  width="50%">Category Title</th>
                <th class="sort" data-sort="last_updated">Last Updated</th>
                <th class="sort">Actions</th>
            </tr>
            </thead>
            
            <tbody class="list">
                <?php if(!empty($product_categories))
                    {
                        foreach ($product_categories as $key) {
                            
                            echo '<tr>';
                                echo '<td class="title">'.$key['cat_title'].'</td>';
                                echo '<td class="last_updated">'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                                echo '<td>';
                                    echo Html::a('View', ['/productcategory/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                                    echo Html::a('Update', ['/productcategory/update', 'id' => $key['id']], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;',]);
                                    
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



<h4>Products</h4>
<div class="col-md-12">
    <div class="filter-table" id="table3" style="margin-bottom:30px;">
        <ul class="pagination pagination3"></ul>
        <table class="table table-bordered no-margin-bottom">
            <thead>
            <tr>
                <th class="sort" data-sort="title"  width="50%">Product Title</th>
                <th class="sort" data-sort="last_updated">Last Updated</th>
                <th class="sort">Actions</th>
            </tr>
            </thead>
            
            <tbody class="list">
                <?php if(!empty($products))
                    {
                        foreach ($products as $key) {
                            
                            echo '<tr>';
                                echo '<td class="title">'.$key['title'].'</td>';
                                echo '<td class="last_updated">'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                                echo '<td>';
                                    echo Html::a('View', ['/product/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                                    echo Html::a('Update', ['/product/update', 'id' => $key['id']], ['class' => 'btn btn-success btn-xs', 'style' => 'margin-left:10px;',]);
                                    
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




<?php

    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/ui/listjs/list.pagination.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

    $this->registerJs("
        var paginationTopOptions1 = {
            name: 'pagination1',
            paginationClass: 'pagination1'
          };
        var paginationTopOptions2 = {
            name: 'pagination1',
            paginationClass: 'pagination2'
          };
        var paginationTopOptions3 = {
            name: 'pagination1',
            paginationClass: 'pagination3'
          };

        var options1 = {
            valueNames: [ 'title','last_updated' ],
            page: 3,
            plugins: [ ListPagination(paginationTopOptions1) ],
        };
        var options2 = {
            valueNames: [ 'title','last_updated' ],
            page: 3,
            plugins: [ ListPagination(paginationTopOptions2) ],
        };
        var options3 = {
            valueNames: [ 'title','last_updated' ],
            page: 3,
            plugins: [ ListPagination(paginationTopOptions3) ],
        };
        
        var userList = new List('table1', options1);
        var userList = new List('table2', options2);
        var userList = new List('table3', options3);

    ", yii\web\View::POS_READY, 'table1df');



?>