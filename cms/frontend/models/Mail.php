<?php

namespace frontend\models;

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
 * @property string $subject
 * @property string $message
 * @property string $type
 * @property string $create_time
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
            [['mailfrom', 'subject', 'message', 'type'], 'required'],
            [['mailto', 'cc', 'bcc', 'message'], 'string'],
            [['create_time'], 'safe'],
            [['mailfrom', 'subject', 'type'], 'string', 'max' => 255]
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
            'create_time' => 'Create Time',
        ];
    }
}
