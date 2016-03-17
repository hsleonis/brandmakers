<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "page_type_rel".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $page_type
 */
class PageTypeRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'page_type'], 'required'],
            [['page_id'], 'integer'],
            [['page_type'], 'string', 'max' => 255]
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
            'page_type' => 'Page Type',
        ];
    }
}
