<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "slider_image".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property string $image
 * @property string $short_title
 * @property string $short_desc
 * @property integer $sort_order
 */
class SliderImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slider_id', 'image', 'short_title', 'short_desc', 'sort_order'], 'required'],
            [['slider_id', 'sort_order'], 'integer'],
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
            'slider_id' => 'Slider ID',
            'image' => 'Image',
            'short_title' => 'Short Title',
            'short_desc' => 'Short Desc',
            'sort_order' => 'Sort Order',
        ];
    }
}
