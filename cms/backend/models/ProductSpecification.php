<?php

namespace backend\models;

use Yii;

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_specification".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $item_name
 * @property string $item_val
 */
class ProductSpecification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'item_name', 'item_val'], 'required'],
            [['product_id'], 'integer'],
            [['item_name', 'item_val'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'item_name' => 'Item Name',
            'item_val' => 'Item Val',
        ];
    }


    public static function getFormAttribs() {
        return [
            // primary key column
            'id'=>[ // primary key attribute
                'type'=>TabularForm::INPUT_HIDDEN, 
                'columnOptions'=>['hidden'=>true]
            ], 
            'item_name'=>[
                'type'=>TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\select2\Select2::classname(),
                'options'=>['data'=>ArrayHelper::map(ProductSpecItem::find()->asArray()->all(), 'name', 'name')]
            ],
            'item_val'=>['type'=>TabularForm::INPUT_TEXT],
        ];
    }



}
