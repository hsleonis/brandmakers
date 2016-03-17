<?php
namespace backend\models;

use Yii;
use yii\base\Model;


class Contact_form extends Model
{
    public $name;
    public $email;
    public $mobile;
    public $interest;
    public $message;


    
    public function rules()
    {
        return [
            [['name', 'email','message'], 'required'],
            ['email', 'email'],
        ];
    }

}
