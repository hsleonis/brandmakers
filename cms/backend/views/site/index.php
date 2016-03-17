<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-3">
                <div class="panel mini-box">
                    <span class="box-icon bg-warning">
                        <span aria-hidden="true" class="glyphicon glyphicon-usd"></span>
                    </span>
                    <div class="box-info">
                        <p class="size-h2">
                            <?php
                                $page = (new \yii\db\Query())
                                    ->select(['count(*) as count'])
                                    ->from('page')
                                    ->one();
                                echo $page['count'];
                             ?>                
                        </p>
                        <p class="text-muted"><span>Pages</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel mini-box">
                    <span class="box-icon bg-info">
                        <span aria-hidden="true" class="glyphicon glyphicon-pushpin"></span>
                    </span>
                    <div class="box-info">
                        <p class="size-h2">
                            <?php
                                $ProductCategory = (new \yii\db\Query())
                                    ->select(['count(*) as count'])
                                    ->from('product_category')
                                    ->one();
                                echo $ProductCategory['count'];
                             ?>                
                        </p>
                        <p class="text-muted"><span>Product Categories</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel mini-box">
                    <span class="box-icon bg-danger">
                        <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                    </span>
                    <div class="box-info">
                        <p class="size-h2">
                            <?php
                                $Post = (new \yii\db\Query())
                                    ->select(['count(*) as count'])
                                    ->from('post')
                                    ->one();
                                echo $Post['count'];
                             ?>    
                        </p>
                        <p class="text-muted"><span>Posts</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel mini-box">
                    <span class="box-icon bg-success">
                        <span aria-hidden="true" class="glyphicon glyphicon-tags"></span>
                    </span>
                    <div class="box-info">
                        <p class="size-h2">
                            <?php
                                $Product = (new \yii\db\Query())
                                    ->select(['count(*) as count'])
                                    ->from('product')
                                    ->one();
                                echo $Product['count'];
                             ?>    
                        </p>
                        <p class="text-muted"><span>Products</span></p>
                    </div>
                </div>
            </div>



        </div>
    </div>


</div>
