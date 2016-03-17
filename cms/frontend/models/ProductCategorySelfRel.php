<?php

namespace frontend\models;

use Yii;
use frontend\models\ProductCategory;

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

    public function getCategory_name()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'parent_cat_id']);
    }

    public function getCategory_name_with_cat_id()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'cat_id']);
    }

    public static function getAllparentCat(){
        $data = [];
        $parent = ProductCategorySelfRel::find()->where(['parent_cat_id'=>0])->all();

        $i=0;
        echo '<pre>';
        foreach ($parent as $key) {
            $data[$i]['title'] = $key->category_name_with_cat_id->cat_title;
            $data[$i]['slug'] = $key->category_name_with_cat_id->cat_slug;
            $data[$i]['sort_order'] = $key->category_name_with_cat_id->sort_order;
            $data[$i]['desc'] = $key->category_name_with_cat_id->cat_desc;

            $i++;
        }

        return $data;
    } 
}
