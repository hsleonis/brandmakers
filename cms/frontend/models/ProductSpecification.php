<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_specification".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $item_name
 * @property string $item_val
 */
class ProductSpecification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'item_name', 'item_val'], 'required'],
            [['product_id'], 'integer'],
            [['item_name', 'item_val'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'item_name' => 'Item Name',
            'item_val' => 'Item Val',
        ];
    }
}
