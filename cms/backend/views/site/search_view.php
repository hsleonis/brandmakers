<?php

use yii\helpers\Html;

?>

<h4>Pages</h4>
<div class="col-md-12">
	<?php if(!empty($pages))
		{
            echo '<table class="table table-striped" style="margin-top:20px;">';
                echo '<tr>';
                    echo '<th width="50%">Page Title</th>';
                    echo '<th>Last Updated</th>';
                    echo '<th>Actions</th>';
                echo '</tr>';
			foreach ($pages as $key) {
				
                echo '<tr>';
                    echo '<td>'.$key['page_title'].'</td>';
                    echo '<td>'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                    echo '<td>';
                        echo Html::a('View', ['/page/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                        echo Html::a('Update', ['/page/update', 'id' => $key['id']], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-left:10px;',]);
                        
                    echo '</td>';
                echo '</tr>';

			}
            echo '</table>';
		} else{
            echo '<p>No results found.</p>';
        }
	?>

</div>


<h4>Product Categories</h4>
<div class="col-md-12">
    <?php if(!empty($product_categories))
        {
            echo '<table class="table table-striped" style="margin-top:20px;">';
                echo '<tr>';
                    echo '<th width="50%">Page Title</th>';
                    echo '<th>Last Updated</th>';
                    echo '<th>Actions</th>';
                echo '</tr>';
            foreach ($product_categories as $key) {
                
                echo '<tr>';
                    echo '<td>'.$key['cat_title'].'</td>';
                    echo '<td>'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                    echo '<td>';
                        echo Html::a('View', ['/productcategory/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                        echo Html::a('Update', ['/productcategory/update', 'id' => $key['id']], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-left:10px;',]);
                        
                    echo '</td>';
                echo '</tr>';

            }
            echo '</table>';
        } else{
            echo '<p>No results found.</p>';
        } 
    ?>

</div>


<h4>Products</h4>
<div class="col-md-12">
    <?php if(!empty($products))
        {
            echo '<table class="table table-striped" style="margin-top:20px;">';
                echo '<tr>';
                    echo '<th width="50%">Page Title</th>';
                    echo '<th>Last Updated</th>';
                    echo '<th>Actions</th>';
                echo '</tr>';
            foreach ($products as $key) {
                
                echo '<tr>';
                    echo '<td>'.$key['title'].'</td>';
                    echo '<td>'.date_format(date_create($key['updated_at']), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($key['updated_at']), 'g:i A').'</td>';
                    echo '<td>';
                        echo Html::a('View', ['/product/view', 'id' => $key['id']], ['class' => 'btn btn-primary btn-xs']);
                        echo Html::a('Update', ['/product/update', 'id' => $key['id']], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-left:10px;',]);
                        
                    echo '</td>';
                echo '</tr>';

            }
            echo '</table>';
        }else{
            echo '<p>No results found.</p>';
        }
    ?>

</div>