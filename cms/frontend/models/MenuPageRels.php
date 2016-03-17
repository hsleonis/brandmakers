<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;

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
            [['menu_id', 'parent_page_id', 'page_id', 'item_title'], 'required'],
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
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public static function getChild_item($id, $menu_id){
        $child = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>$id,'menu_id'=>$menu_id])->all();
        
        return $child;
    }



    public static function getChild_pages($page_id, $menu_id){
        $html = '';
        $child = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>$page_id,'menu_id'=>$menu_id])->all();
        
        if(!empty($child)){
            $html .= '<ul>';
            foreach ($child as $value) {
                 $html .= '<li><a href="'.Url::toRoute(['/page','id'=>$value->page_rel->id]).'">'.($value->item_title?:$value->page_rel->page_title).'</a>';
                   
                     $html .= MenuPageRels::getChild_pages($value->page_id, $value->menu_id, $html);
                    
                 $html .= '</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    public static function getHierarchy_page($menu_id) {
        $html = '';

        $parent = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>0,'menu_id'=>$menu_id])->all();
        
        if(!empty($parent)){
            $html .= '<ul class="main_menu">';
            foreach ($parent as $value) {
                 $html .= '<li><a href="'.Url::toRoute(['/page','id'=>$value->page_rel->id]).'">'.($value->item_title?:$value->page_rel->page_title).'</a>';
                   
                    $html .= MenuPageRels::getChild_pages($value->page_id, $value->menu_id);
                    
                 $html .= '</li>';
            }
            $html .= '</ul>';
        }
        

        return $html;
    }





    public static function getMenu($menu_id) {
        $options = [];

        $parent = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>0,'menu_id'=>$menu_id])->all();
        
        if(!empty($parent)){
            foreach ($parent as $key => $value) {
                //echo $value->page_rel->page_title;
                $options[$value->page_rel->page_slug]['page_data'] = $value->page_rel;
                $options[$value->page_rel->page_slug]['sort_order'] = $value->id;
            }
        }
        

        return $options;
    }

    public static function getMenu_new($menu_id){
        $options = [];
        $i = 0;
        $parent = MenuPageRels::find()->joinWith('page_rel')->where(['parent_page_id'=>0,'menu_id'=>$menu_id])->all();
        
        if(!empty($parent)){
            foreach ($parent as $key => $value) {
                //echo $value->page_rel->page_title;
                $options[$i]['title'] = $value->page_rel->page_title;
                $options[$i]['slug'] = $value->page_rel->page_slug;
                $options[$i]['sort_order'] = $value->id;
                $i++;
            }
        }
        

        return $options;
    }


}
