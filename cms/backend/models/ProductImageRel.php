<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_image_rel".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image
 * @property string $title
 * @property string $desc
 */
class ProductImageRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id'], 'integer'],
            [['image', 'title', 'desc'], 'string', 'max' => 255]
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
            'image' => 'Image',
            'title' => 'Title',
            'desc' => 'Desc',
        ];
    }
}
