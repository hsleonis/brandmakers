<?php

namespace frontend\models;

use Yii;
use frontend\models\ProductCategory;
use frontend\models\ProductCategorySelfRel;

/**
 * This is the model class for table "product_category_rel".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $product_id
 * @property integer $sort_order
 */
class ProductCategoryRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id', 'sort_order'], 'required'],
            [['category_id', 'product_id', 'sort_order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'product_id' => 'Product ID',
            'sort_order' => 'Sort Order',
        ];
    }

    public function getproducts()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getCategory_name()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

     public function getProject_category_category_self_rel(){
        return $this->hasOne(ProductCategorySelfRel::className(), ['cat_id' => 'category_id']);
    }


}
