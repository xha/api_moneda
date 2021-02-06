<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $usuario;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // usuario and password are both required
            [['usuario', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword("is".$this->password)) {
                $this->addError($attribute, 'Clave o usuario incorrecto');
            }
        }
    }

    /**
     * Logs in a user using the provided usuario and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*12*1 : 0);
            return Yii::$app->getResponse()->redirect(array('/index',302));
        }
        return false;
    }

    /**
     * Finds user by [[usuario]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->usuario);
        }

        return $this->_user;
    }
}
