<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_category_self_rel".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $parent_cat_id
 */
class ProductCategorySelfRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category_self_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'parent_cat_id'], 'required'],
            [['cat_id', 'parent_cat_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'parent_cat_id' => 'Parent Cat ID',
        ];
    }
}
