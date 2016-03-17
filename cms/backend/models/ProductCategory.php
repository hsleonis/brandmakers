<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use app\models\User;
use backend\models\Page;
use backend\models\ProductCategorySelfRel;

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $cat_title
 * @property string $cat_desc
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_title', 'cat_desc', 'cat_slug'], 'required'],
            [['cat_desc'], 'string'],
            [['created_at', 'updated_at', 'sort_order'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['cat_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_title' => 'Category Title',
            'cat_desc' => 'Category Desc',
            'cat_slug' => 'Category Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'createUserName' => Yii::t('app', 'Created By'),
            'updateUserName' => Yii::t('app', 'Updated By'),
            'sort_order' => 'Sort Order'
        ];
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
     
           /**
           * @getCreateUserName
           *
           */
     
    public function getCreateUserName()
    {
        return $this->createUser ? $this->createUser->username : '- no user -';
    }

    public function getUpdateUser()
    {
       return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
           /**
           * @getUpdateUserName
           *
           */
     
    public function getUpdateUserName()
    {
        return $this->createUser ? $this->updateUser->username : '- no user -';
    } 


    public function getcat_rel()
    {
        return $this->hasMany(ProductCategorySelfRel::className(), ['cat_id' => 'id']);
    }

    public function getproducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_category_rel', ['category_id' => 'id']);
    }

    public static function get_child_cat($parent, $options, $dot){
        if($dot==''){
            $dot = '--';
        }
        
        $child_pages = self::find()->joinWith('cat_rel')->where(['product_category_self_rel.parent_cat_id'=>$parent])->all();

        if(!empty($child_pages)){
            foreach ($child_pages as $key => $value) {
                $options[$value->id] = $dot.$value->cat_title;
                $options=self::get_child_cat($value->id, $options, $dot.'--');
            }
        }

        return $options;
    }

    public static function getHierarchy_cat() {
        $options = [];
        $dot = '';

        $parent_pages = self::find()->joinWith('cat_rel')->where(['product_category_self_rel.parent_cat_id'=>0])->all();
        
        if(!empty($parent_pages)){
            foreach ($parent_pages as $key => $value) {
                $options[$value->id] = $value->cat_title;

                $options = self::get_child_cat($value->id, $options, $dot);
            }
        }
        

        return $options;
    }

    public static function update_ProductCategory_self_rel($model){
        
        ProductCategorySelfRel::deleteAll(['cat_id' => $model->cat_id]);


        foreach ($model->parent_cat_id as $key => $value) {
            $new_model = new ProductCategorySelfRel();
            $new_model->cat_id = $model->cat_id;
            $new_model->parent_cat_id = $value;

            if($new_model->save()){

            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return true;
    }



    public static function get_subcategory_list($parent){
        $html = '';
        $child_pages = ProductCategory::find()->joinWith('cat_rel')->where(['product_category_self_rel.parent_cat_id'=>$parent])->all();

        if(!empty($child_pages)){
            $html .= '<ul>';
            foreach ($child_pages as $key => $value) {
                $html .= '<li><a href="#" data_cat_id="'.$value->id.'">'.$value->cat_title.'</a></li>';
                self::get_subcategory_list($value->id, $html);
            }
            $html .= '</ul>';
        }

        return $html;
    }











    public static function getFormAttribs() {
        return [
            // primary key column
            'id'=>[ // primary key attribute
                'type'=>TabularForm::INPUT_HIDDEN, 
                'columnOptions'=>['hidden'=>true]
            ], 
            'cat_title'=>[
                'type'=>TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\select2\Select2::classname(),
                'options'=>['data'=>ArrayHelper::map(Page::find()->asArray()->all(), 'id', 'page_title')]
            ],
            'cat_desc'=>['type'=>TabularForm::INPUT_TEXT],
        ];
    }
}
