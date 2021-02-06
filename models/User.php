<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $username;

    public static function tableName()
    {
        return 'usuarios';
    }

    public static function findIdentity($id)
    {
         $user = Usuario::find()
                ->where("activo=:activate", [":activate" => 1])
                ->andWhere("idUsuario=:id", ["id" => $id])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach ($users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by usuario
     *
     * @param string $usuario
     * @return static|null
     */
    public static function findByUsername($usuario)
    {
        $users = Usuario::find()
                ->where("activo=:activate", ["activate" => 1])
                ->andWhere("usuario=:usuario", [":usuario" => $usuario])
                ->all();

        foreach ($users as $user) {
            if (strcasecmp($user['usuario'], $usuario) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->idUsuario;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if (md5($password) == $this->password)
        {
            return $password === $password;
        }
    }
}
