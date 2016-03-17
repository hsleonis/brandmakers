<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page_image_rel".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $image
 * @property string $short_title
 * @property string $short_desc
 */
class PageImageRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_image_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'image'], 'required'],
            [['page_id', 'sort_order', 'is_gallery','is_banner'], 'integer'],
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
            'page_id' => 'Page ID',
            'image' => 'Image',
            'short_title' => 'Short Title',
            'short_desc' => 'Short Desc',
        ];
    }
}
