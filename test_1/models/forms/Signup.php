<?php
namespace app\models\forms;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
{
    public $fio;
    public $email;
    public $password;
    public $password_repeat;
    public $inn;
    public $company_name;
    public $type_id = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'email'], 'filter', 'filter' => 'trim'],
            [['fio', 'email', 'password', 'password_repeat', 'type_id'], 'required'],
            ['fio', 'string', 'min' => 2, 'max' => 255],
            ['type_id', 'integer'],
            ['email', 'email'],
            [['email', 'inn', 'company_name'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password', 'compare'],
            [
                ['inn', 'company_name'],
                'required' ,
                'when' => function ($model) {
                    return $model->type_id == User::TYPE_ENTITY;
                },
                'whenClient' => "function (attribute, value) {
                    return $('input[name=\"Signup[type_id]\"][type=radio]:checked').val() == 1;
                }"
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'type_id' => 'Тип лица физ./юр',
            'inn' => 'ИНН',
            'company_name' => 'Название организации',
            'password_repeat' => 'Пароль',
            'password' => 'Повторите пароль',
            'email' => 'Email',
        ];
    }

    /**
     * Sign user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();
        $user->setAttributes($this->getAttributes(null, ['password', 'password_repeat']));
        $user->setPassword($this->password);
        $user->auth_key =  Yii::$app->getSecurity()->generateRandomString();
        if ($user->save() == false) {
            return null;
        }
        Yii::$app->user->login($user, 3600*24*30);
        return $user;
    }
}
