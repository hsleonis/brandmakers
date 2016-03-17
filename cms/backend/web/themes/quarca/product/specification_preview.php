<?php

if(!empty($data)){
	foreach ($data as $key => $value) {
		echo '<p><strong>'.$value->item_name.'</strong><br/>'.$value->item_val.'</p>';
	}
}


?>