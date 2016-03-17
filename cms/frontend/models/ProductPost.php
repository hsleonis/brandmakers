<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_post".
 *
 * @property integer $id
 * @property string $post_title
 * @property string $post_desc
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $product_id
 * @property integer $sort_order
 */
class ProductPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_title', 'post_desc', 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_id', 'sort_order'], 'required'],
            [['post_desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'product_id', 'sort_order'], 'integer'],
            [['post_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_title' => 'Post Title',
            'post_desc' => 'Post Desc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'product_id' => 'Product ID',
            'sort_order' => 'Sort Order',
        ];
    }
}
