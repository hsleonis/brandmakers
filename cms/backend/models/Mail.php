<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "mail".
 *
 * @property integer $id
 * @property string $mailto
 * @property string $mailfrom
 * @property string $cc
 * @property string $bcc
 * @property string $message
 * @property string $type
 */
class Mail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['mailto'], 'required','message' => 'To cannot be blank.', 'on' => 'mail'],
            [['message'], 'required','message' => 'Message cannot be blank.', 'on' => 'draft'],
            [['message', 'type','subject'], 'required', 'on' => 'mail'],

            [['mailto', 'cc', 'bcc', 'message'], 'string'],
            [['mailfrom', 'type'], 'string', 'max' => 255],
            [['create_time','trash'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mailto' => 'Mailto',
            'mailfrom' => 'Mailfrom',
            'cc' => 'Cc',
            'bcc' => 'Bcc',
            'subject' => 'Subject',
            'message' => 'Message',
            'type' => 'Type',
            'create_time' => 'Create Time'
        ];
    }

    public static function limit_str($length, $string){
        $charset = 'UTF-8';
        if(mb_strlen($string, $charset) > $length) {
            $string = mb_substr($string, 0, $length - 3, $charset) . ' ...';
        }

        return $string;
    }
}
