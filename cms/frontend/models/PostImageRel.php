<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post_image_rel".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $image
 * @property string $short_title
 * @property string $short_desc
 */
class PostImageRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_image_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'image', 'short_title', 'short_desc'], 'required'],
            [['post_id'], 'integer'],
            [['image', 'short_title', 'short_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'image' => 'Image',
            'short_title' => 'Short Title',
            'short_desc' => 'Short Desc',
        ];
    }
}
