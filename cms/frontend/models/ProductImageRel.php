<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_image_rel".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image
 * @property string $title
 * @property string $desc
 * @property integer $is_banner
 * @property integer $is_gallery
 * @property integer $sort_order
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
            [['product_id', 'image', 'title', 'desc', 'is_banner', 'is_gallery', 'is_hover', 'sort_order'], 'required'],
            [['product_id', 'is_banner', 'is_gallery', 'sort_order'], 'integer'],
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
            'is_banner' => 'Is Banner',
            'is_gallery' => 'Is Gallery',
            'is_hover' => 'Is Hover',
            'sort_order' => 'Sort Order',
        ];
    }
}
