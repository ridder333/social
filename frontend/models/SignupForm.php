<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Image;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $firstname;
    public $surname;
    public $sex_id;
    public $birthday;
    public $description;
    public $avatar;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'firstname', 'surname', 'email', 'description'], 'trim'],
            [['username', 'firstname', 'surname', 'email', 'password', 'sex_id', 'birthday'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот логин уже занят.'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот Email уже занят.'],
            [['username', 'firstname', 'surname'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'string', 'max' => 255],
            ['description', 'string', 'max' => 3000],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            [['avatar'], 'file', 'extensions' => 'png, jpg, gif', 'maxSize' => 1024 * 1024 * 5],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'sex_id' => 'Пол',
            'birthday' => 'День рождения',
            'description' => 'О себе',
            'avatar' => 'Фото',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->firstname = $this->firstname;
        $user->surname = $this->surname;
        $user->sex_id = $this->sex_id;
        $user->birthday = $this->birthday;
        $user->description = $this->description;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if (!$user->save()) {
            return null;
        }
        
        $imageFile = UploadedFile::getInstance($this, 'avatar');
        if ($imageFile) {
            $image = new Image();
            $image->user_id = $user->id;
            $image->name = md5(time()) . "." . $imageFile->extension;
            if ($image->upload($imageFile)) {
                if ($image->save()) {
                    $user->avatar_id = $image->id;
                    $user->save();
                }
            }
        }
        
        return $user;
    }    
}
