<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_category_rel".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $product_id
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
            [['category_id', 'product_id'], 'required'],
            [['category_id', 'product_id'], 'integer'],
            [['sort_order'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'product_id' => 'Product ID',
        ];
    }

    public function getproducts()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
