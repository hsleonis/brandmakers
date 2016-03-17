<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_files".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $file_name
 * @property string $title
 */
class ProductFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'file_name', 'title'], 'required'],
            [['product_id'], 'integer'],
            [['file_name', 'title'], 'string', 'max' => 255]
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
            'file_name' => 'File Name',
            'title' => 'Title',
        ];
    }
}
