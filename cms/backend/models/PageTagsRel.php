<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page_tags_rel".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $tag_id
 */
class PageTagsRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_tags_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'tag_id'], 'required'],
            [['page_id', 'tag_id'], 'integer']
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
            'tag_id' => 'Tag ID',
        ];
    }
}
