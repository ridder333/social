<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * UserUpdateForm form
 */
class UserUpdateForm extends Model
{
    public $firstname;
    public $surname;
    public $sex_id;
    public $birthday;
    public $description;
    public $email;
    
    /**
     * @var User
     */
    private $_user;
    
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->firstname = $user->firstname;
        $this->surname = $user->surname;
        $this->sex_id = $user->sex_id;
        $this->birthday = $user->birthday;
        $this->description = $user->description;
        $this->email = $user->email;
        parent::__construct($config);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'surname', 'email', 'description'], 'trim'],
            [['firstname', 'surname', 'email', 'sex_id', 'birthday'], 'required'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот Email уже занят.', 'filter' => ['<>', 'id', $this->_user->id]],
            [['firstname', 'surname'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'string', 'max' => 255],
            ['description', 'string', 'max' => 3000],
            ['email', 'email'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'sex_id' => 'Пол',
            'birthday' => 'День рождения',
            'description' => 'О себе',
        ];
    }

    /**
     * 
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = $this->_user;
        $user->firstname = $this->firstname;
        $user->surname = $this->surname;
        $user->sex_id = $this->sex_id;
        $user->birthday = $this->birthday;
        $user->description = $this->description;
        $user->email = $this->email;
        
        return $user->save();
    }    
}
