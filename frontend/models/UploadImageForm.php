<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Image;
use yii\web\UploadedFile;

/**
 * UploadImageForm form
 */
class UploadImageForm extends Model
{
    public $avatar;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avatar'], 'file', 'extensions' => 'png, jpg, gif', 'maxSize' => 1024 * 1024 * 5, 'skipOnEmpty' => false],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'avatar' => 'Фото',
        ];
    }
    
    public function beforeValidate()
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        return parent::beforeValidate();
    } 

    /**
     * 
     *
     * @return bool
     */
    public function upload()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $imageFile = $this->avatar;
        if ($this->avatar) {
            $image = new Image();
            $image->user_id = Yii::$app->user->identity->getId();
            $image->name = md5(time()) . "." . $imageFile->extension;
            if($image->upload($imageFile)) {
                $image->save();
            }
        }
        
        return true;
    }    
}
