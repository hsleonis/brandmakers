<?php

namespace backend\models;

use Yii;
use backend\models\PageSelfRels;
use backend\models\PageTypeRel;
use backend\models\Tags;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use app\models\User;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $page_title
 * @property string $page_slug
 * @property string $short_desc
 * @property string $meta_key
 * @property string $meta_desc
 * @property string $date
 * @property string $page_desc
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends \yii\db\ActiveRecord
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
        return 'page';
    }

    public $child_count;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_title', 'page_slug', 'status'], 'required'],
            [['date', 'created_at', 'updated_at','sort_order', 'ext_url'], 'safe'],
            [['page_desc'], 'string'],
            [['is_archive'],'integer'],
            [['page_title', 'page_slug', 'short_desc', 'meta_key', 'meta_desc'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50]
        ];
    }

    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_title' => 'Page Title',
            'page_slug' => 'Page Slug',
            'short_desc' => 'Short Desc',
            'ext_url' => 'External Url',
            'meta_key' => 'Meta Key',
            'meta_desc' => 'Meta Desc',
            'date' => 'Date',
            'page_desc' => 'Page Desc',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'createUserName' => Yii::t('app', 'Created By'),
            'updateUserName' => Yii::t('app', 'Updated By'),
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

    public function getPage_rel()
    {
        return $this->hasMany(PageSelfRels::className(), ['page_id' => 'id']);
    }

    public function getPage_type_rel()
    {
        return $this->hasMany(PageTypeRel::className(), ['page_id' => 'id']);
    }

    public function getPage_image_rel()
    {
        return $this->hasMany(PageImageRel::className(), ['page_id' => 'id']);
    }
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('page_tags_rel', ['page_id' => 'id']);
    }


    public static function get_child_pages($parent, $options, $dot){
        if($dot==''){
            $dot = '--';
        }
        
        $child_pages = self::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$parent])->all();

        if(!empty($child_pages)){
            foreach ($child_pages as $key => $value) {
                $options[$value->id] = $dot.$value->page_title;
                $options=self::get_child_pages($value->id, $options, $dot.'--');
            }
        }

        return $options;
    }

    public static function getHierarchy_page() {
        $options = [];
        $dot = '';

        $parent_pages = self::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>0])->all();
        
        if(!empty($parent_pages)){
            foreach ($parent_pages as $key => $value) {
                $options[$value->id] = $value->page_title;

                $options = self::get_child_pages($value->id, $options, $dot);
            }
        }
        

        return $options;
    }


    public static function get_breadcumb_parent($id, $options){
        $parent_page_id = PageSelfRels::find()->where(['page_id'=>$id])->one();
        $parent_pages = Page::find()->where(['id'=>$parent_page_id->parent_page_id])->one();

        if($parent_page_id->parent_page_id != 0){
            $options[$parent_page_id->parent_page_id]['id'] = $parent_page_id->parent_page_id;
            $options[$parent_page_id->parent_page_id]['title'] = $parent_pages->page_title;

            $options = self::get_breadcumb_parent($parent_page_id->parent_page_id, $options);
        }

        return $options;
    }

    public static function get_breadcumb($id){
        $parent_page_id = PageSelfRels::find()->where(['page_id'=>$id])->one();
        $parent_pages = Page::find()->where(['id'=>$parent_page_id->parent_page_id])->one();

        $options = [];

        if($parent_page_id->parent_page_id != 0){
            $options[$parent_page_id->parent_page_id]['id'] = $parent_page_id->parent_page_id;
            $options[$parent_page_id->parent_page_id]['title'] = $parent_pages->page_title;

            $options = self::get_breadcumb_parent($parent_page_id->parent_page_id, $options);
        }
        

        return $options;
    }



    public static function update_page_self_rel($model){
        
        PageSelfRels::deleteAll(['page_id' => $model->page_id]);


        foreach ($model->parent_page_id as $key => $value) {
            $new_model = new PageSelfRels();
            $new_model->page_id = $model->page_id;
            $new_model->parent_page_id = $value;

            if($new_model->save()){

            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return true;
    }

    public static function update_page_type_rel($model){

        PageTypeRel::deleteAll('page_id = :page_id', [':page_id' => $model->page_id]);

        foreach ($model->page_type as $key => $value) {
            $new_model = new PageTypeRel();
            $new_model->page_id = $model->page_id;
            $new_model->page_type = $value;

            if($new_model->save()){

            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return true;
    }

    public static function update_page_tags_rel($model){

        PageTagsRel::deleteAll('page_id = :page_id', [':page_id' => $model->page_id]);

        foreach ($model->tag_id as $key => $value) {
            $new_model = new PageTagsRel();
            $new_model->page_id = $model->page_id;
            $new_model->tag_id = $value;

            if($new_model->save()){

            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return true;
    }

    public static function archive_all_child($id){

        $child = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$id])->all();

        if(!empty($child)){
            foreach ($child as $value) {
                $value->is_archive = 1;
                $value->save();
                Page::archive_all_child($value->id);
            }
        }

        return true;
    }

    public static function restore_all_child($id){

        $child = Page::find()->joinWith('page_rel')->where(['page_self_rels.parent_page_id'=>$id])->all();

        if(!empty($child)){
            foreach ($child as $value) {
                $value->is_archive = 0;
                $value->save();
                Page::restore_all_child($value->id);
            }
        }

        return true;
    }


}
