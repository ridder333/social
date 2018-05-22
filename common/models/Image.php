<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property int $user_id
 *
 * @property User $user
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * Loads image
     * 
     * @param \yii\web\UploadedFile $imageFile
     * @return bool 
     */
    public function upload($imageFile)
    {
        $uploadDir = Yii::getAlias('@frontend') . '/web/' . User::IMG_PATH . $this->user_id;
        if (!is_dir($uploadDir)){
            mkdir($uploadDir,0755);
        }
        
        return $imageFile->saveAs($uploadDir . '/' . $this->name);
    }
}
