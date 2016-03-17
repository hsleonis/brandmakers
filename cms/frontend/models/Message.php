<?php

namespace frontend\models;

use yii\base\Model;

class Message extends Model
{

    public $name;
    public $email;
    public $message;

    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required'],
            [['email'],'email'],
            [['name', 'email'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 300]
        ];
    }

}
