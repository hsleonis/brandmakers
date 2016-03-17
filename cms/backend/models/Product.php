<?php

namespace backend\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use app\models\User;
use backend\models\ProductCategoryRel;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends \yii\db\ActiveRecord
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
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'desc', 'status'], 'required'],
            [['desc'], 'string'],
            [['status', 'created_by', 'updated_by', 'sort_order', 'is_featured'], 'integer'],
            [['created_at', 'updated_at', 'slug'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'desc' => 'Desc',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'createUserName' => Yii::t('app', 'Created By'),
            'updateUserName' => Yii::t('app', 'Updated By'),
            'sort_order' => 'Sort Order',
            'is_featured' => 'Is Featured?'
        ];
    }

    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

     
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
/*
    public function getPost_image_rel()
    {
        return $this->hasMany(PostImageRel::className(), ['post_id' => 'id']);
    }*/

    public static function update_product_category_rel($model){
        
        ProductCategoryRel::deleteAll(['product_id' => $model->product_id]);


        foreach ($model->category_id as $key => $value) {
            $new_model = new ProductCategoryRel();
            $new_model->product_id = $model->product_id;
            $new_model->category_id = $value;

            if($new_model->save()){

            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return true;
    }


    public function getproduct_image()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->orderBy('sort_order asc');
    }


    public function getproduct_files()
    {
        return $this->hasMany(ProductFiles::className(), ['product_id' => 'id']);
    }


}
