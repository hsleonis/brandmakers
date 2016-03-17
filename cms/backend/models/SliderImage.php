<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "slider_image".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property string $image
 * @property string $short_title
 * @property string $short_desc
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
            [['slider_id', 'image'], 'required'],
            [['slider_id'], 'integer'],
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
        ];
    }
}
