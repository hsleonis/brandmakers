<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "page_image_rel".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $image
 * @property string $short_title
 * @property string $short_desc
 * @property integer $sort_order
 * @property integer $is_gallery
 * @property integer $is_banner
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
            [['page_id', 'image', 'short_title', 'short_desc', 'sort_order', 'is_gallery', 'is_banner'], 'required'],
            [['page_id', 'sort_order', 'is_gallery', 'is_banner'], 'integer'],
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
            'sort_order' => 'Sort Order',
            'is_gallery' => 'Is Gallery',
            'is_banner' => 'Is Banner',
        ];
    }
}
