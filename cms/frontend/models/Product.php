<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use frontend\models\ProductImageRel;
use frontend\models\ProductSpecification;
use frontend\models\ProductFiles;
use frontend\models\ProductCategoryRel;
use frontend\models\ProductCategorySelfRel;

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
            [['title', 'desc', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['desc'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'desc' => 'Desc',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getPost()
    {
        return $this->hasMany(ProductPost::className(), ['product_id' => 'id'])->orderBy('product_post.sort_order asc');
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['product_id' => 'id'])->andWhere(['is_approved'=>'1']);
    }

    public function getImage_all()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->orderBy('sort_order asc');
    }

    public function getImage_by_banner()
    {
        return $this->hasOne(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_banner'=>'1'])->orderBy('sort_order asc');
    }

    public function getImage_by_gallery()
    {
        return $this->hasOne(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_gallery'=>'1'])->orderBy('sort_order asc');
    }

    public function getImage_by_banner_all()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_banner'=>'1'])->orderBy('sort_order asc');
    }
    
    public function getImage_by_thumb_all()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_thumbnail'=>'1'])->orderBy('sort_order asc');
    }
    
    public function getImage_by_gallery_all()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_gallery'=>'1'])->orderBy('sort_order asc');
    }

    public function getImage_by_hover_all()
    {
        return $this->hasMany(ProductImageRel::className(), ['product_id' => 'id'])->andWhere(['is_hover'=>'1'])->orderBy('sort_order asc');
    }

    public function getFiles_all()
    {
        return $this->hasMany(ProductFiles::className(), ['product_id' => 'id']);
    }

    public function getProject_category_rel()
    {
        return $this->hasOne(ProductCategoryRel::className(), ['product_id' => 'id']);
    }

   
    public function getSpecification()
    {
        return $this->hasMany(ProductSpecification::className(), ['product_id' => 'id']);
    }

    public function getCat_rel(){
        return $this->hasMany(ProductCategoryRel::className(), ['product_id' => 'id']);
    }


    public static function product_data($id){
        return Product::find()->where(['id' => $id])->one();   
    }



    public static function getProduct_by_slug($slug){
        $options = [];

        $product = self::find()->where(['slug'=>$slug])->one();

        $options['data'] = $product;
        $options['images_banner'] = $product->image_by_banner_all;
        $options['images_gallery'] = $product->image_by_gallery_all;
        $options['images_hover'] = $product->image_by_hover_all;
        $options['files'] = $product->files_all;
        $options['comments'] = $product->comments;
        //$options['specification'] = $product->specification;
        foreach ($product->specification as $spec) {
            $options['specification'][$spec['item_name']] = $spec;
        }

        foreach ($product->post as $key => $value) {
            $options['posts'][$value->slug] = $value;
        }
        

        return $options;
    }


    public static function getProduct_title_list(){
        $options = array();

        $product = self::find()->all();

        foreach ($product as $key => $value) {
            //$options[$value->title] = $value->title;
            array_push($options, $value->title);
        }
        

        return $options;
    }

    public static function getProduct_location_list(){
        $options = array();

        $product = self::find()->all();

        foreach ($product as $p) {
            foreach ($p->specification as $key => $value) {

                if($value->item_name=='Location'){
                    array_push($options, $value->item_val);
                }
                
            }
        }
        
        return $options;
    }

    

    public static function get_all_product(){

        $options = [];
        $i = 0;
        $product_list_r = Product::find()->joinWith('cat_rel')->orderBy('product_category_rel.sort_order desc')->all();

        foreach($product_list_r as $key => $value){

            $options[$i]['project_id'] = self::product_data($value->id)->id;
            $options[$i]['project_title'] = self::product_data($value->id)->title;
            $options[$i]['project_slug'] = self::product_data($value->id)->slug;
            $options[$i]['project_location'] = "";
            $options[$i]['project_image'] = "";
            $options[$i]['project_image_full'] = "";
            $options[$i]['project_order'] = self::product_data($value->id)->sort_order;
            $options[$i]['is_featured'] = self::product_data($value->id)->is_featured;

            if(!empty($value->specification)){
                foreach ($value->specification as $spec) {
                    if($spec->item_name=='Location'){
                        $options[$i]['project_location'] = $spec->item_val;
                    }
                }
            }

            if(!empty($value->image_by_banner_all)){
                $j=0;   
                    
                foreach ($value->image_by_banner_all as $banner) {
                    if($j==0){

                        $options[$i]['project_image'] = Yii::$app->urlManager->createAbsoluteUrl('/').'product_uploads/thumb/'.$banner->image;
                        $options[$i]['project_image_full'] = Yii::$app->urlManager->createAbsoluteUrl('/').'product_uploads/'.$banner->image;
                    }
                }
                    
              if(!empty($value->image_by_thumb_all)){
                    $j=0;
                        foreach ($value->image_by_thumb_all as $thumb) {
                        if($j==0){
                            $options[$i]['project_image'] = Yii::$app->urlManager->createAbsoluteUrl('/').'product_uploads/'.$thumb->image;

                        }
                    }
               }
                
            }
            
            $options[$i]['project_type'] = $value->project_category_rel->category_name['cat_title'];
            $options[$i]['project_category'] = $value->project_category_rel->project_category_category_self_rel['category_name']['cat_title'];
            $i++;
        }

        return $options;
    }




    public static function get_all_product_with_detail(){

        $options = [];
        $i = 0;
        $product_list_r = Product::find()->joinWith('cat_rel')->orderBy('product_category_rel.sort_order desc')->all();

        foreach($product_list_r as $key => $value){

            $options[self::product_data($value->id)->slug]['id'] = self::product_data($value->id)->id;
            $options[self::product_data($value->id)->slug]['title'] = self::product_data($value->id)->title;
            $options[self::product_data($value->id)->slug]['slug'] = self::product_data($value->id)->slug;
            $options[self::product_data($value->id)->slug]['desc'] = self::product_data($value->id)->desc;
            $options[self::product_data($value->id)->slug]['project_location'] = "";
            $options[self::product_data($value->id)->slug]['project_banner'] = "";
            $options[self::product_data($value->id)->slug]['spec'] = "";
            $options[self::product_data($value->id)->slug]['project_order'] = self::product_data($value->id)->sort_order;
            $options[self::product_data($value->id)->slug]['is_featured'] = self::product_data($value->id)->is_featured;

            if(!empty($value->specification)){
                $k=0;
                foreach ($value->specification as $spec) {
                    
                    $options[self::product_data($value->id)->slug]['specification'][$k] = $spec;
                    if($spec->item_name=='Location'){
                        $options[self::product_data($value->id)->slug]['project_location'] = $spec->item_val;
                    }
                    $k++;
                }
            }

            if(!empty($value->image_all)){
                $j=0;
                foreach ($value->image_all as $banner) {
                    
                    $options[self::product_data($value->id)->slug]['images'][$j]['url'] = Yii::$app->urlManager->createAbsoluteUrl('/').'product_uploads/'.$banner->image;
                    $options[self::product_data($value->id)->slug]['images'][$j]['title'] = $banner->title;
                    $options[self::product_data($value->id)->slug]['images'][$j]['desc'] = $banner->desc;
                    $options[self::product_data($value->id)->slug]['images'][$j]['sort_order'] = $banner->sort_order;
                    $options[self::product_data($value->id)->slug]['images'][$j]['is_banner'] = $banner->is_banner;
                    $options[self::product_data($value->id)->slug]['images'][$j]['is_gallery'] = $banner->is_gallery;
                    $options[self::product_data($value->id)->slug]['images'][$j]['is_hover'] = $banner->is_hover;
                    if($banner->is_banner)
                    $options[self::product_data($value->id)->slug]['project_banner'] = Yii::$app->urlManager->createAbsoluteUrl('/').'product_uploads/'.$banner->image;
                    
                    $j++;
                }
            }

            if(!empty($value->post)){
                $j=0;
                foreach ($value->post as $post) {
                    if($j==0)
                        $options[self::product_data($value->id)->slug]['spec'] = $post->post_desc;
                    $options[self::product_data($value->id)->slug]['posts'][$j] = $post;
                    $j++;
                }
            }

            $options[self::product_data($value->id)->slug]['type'] = $value->project_category_rel->category_name['cat_title'];
            $options[self::product_data($value->id)->slug]['category'] = $value->project_category_rel->project_category_category_self_rel['category_name']['cat_title'];
            $i++;
        }

        return $options;
    }




}
