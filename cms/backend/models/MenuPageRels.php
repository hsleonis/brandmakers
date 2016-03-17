<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu_page_rels".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $parent_page_id
 * @property integer $page_id
 * @property string $item_title
 */
class MenuPageRels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_page_rels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_page_id', 'page_id'], 'required'],
            [['menu_id', 'parent_page_id', 'page_id'], 'integer'],
            [['item_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'parent_page_id' => 'Parent Page ID',
            'page_id' => 'Page ID',
            'item_title' => 'Item Title',
        ];
    }

    public function getPage_rel()
    {
        // Order has_one Customer via Customer.id -> customer_id
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public static function test($page_id, $item_title, $page_title){
           $fsdfsd ='<div class="menuDiv">';
               
               $fsdfsd.='<span>';
                   $fsdfsd.='<span data-id="'.$page_id.'" class="itemTitle">'.$item_title.'</span>';
                   $fsdfsd.='<span title="Click to delete item." data-id="'.$page_id.'" class="deleteMenu ui-icon ui-icon-closethick">';
                        $fsdfsd.='<span class="glyphicon glyphicon-trash"></span>';
                   $fsdfsd.='</span>';
               $fsdfsd.='</span>';
               $fsdfsd.='<div id="menuEdit'.$page_id.'" class="menuEdit">';
                   $fsdfsd.='<p>';
                       $fsdfsd.=$page_title;
                   $fsdfsd.='</p>';
               $fsdfsd.='</div>';
           $fsdfsd.='</div>';

        return $fsdfsd;
    }
}
