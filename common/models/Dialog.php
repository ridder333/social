<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "dialog".
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $last_message_id
 * @property string $updated_at
 *
 * @property User $fromUser
 * @property Message $message
 * @property User $toUser
 */
class Dialog extends ActiveRecord
{
    const PAGE_SIZE = 4;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'last_message_id'], 'required'],
            [['from_user_id', 'to_user_id', 'last_message_id'], 'integer'],
            [['from_user_id', 'to_user_id'], 'unique', 'targetAttribute' => ['from_user_id', 'to_user_id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['last_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['last_message_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'last_message_id' => 'Message ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'last_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
}
