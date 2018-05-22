<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Password update form
 */
class UpdatePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
 
    /**
     * @var User
     */
    private $_user;
 
    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }
 
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'currentPassword'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повтор нового пароля',
            'currentPassword' => 'Текущий пароль',
        ];
    }
 
    /**
     * @param string $attribute
     * @param array $params
     */
    public function currentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Текущий пароль введен неверно!');
            }
        }
    }
 
    /**
     * @return boolean
     */
    public function updatePassword()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = $this->_user;
        $user->setPassword($this->newPassword);
        return $user->save();
    }
}
