<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page_self_rels".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $parent_page_id
 */
class PageSelfRels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_self_rels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id'], 'required'],
            [['page_id', 'parent_page_id'], 'integer']
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
            'parent_page_id' => 'Parent Page ID',
        ];
    }


    

}
