<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $idUsuario
 * @property string $usuario
 * @property string $password
 * @property string|null $fechaCreacion
 * @property bool $activo
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario', 'password'], 'required'],
            [['fechaCreacion','idUsuario'], 'safe'],
            [['activo'], 'boolean'],
            [['usuario'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 100],
            [['usuario'], 'unique'],
            [['idUsuario'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id',
            'usuario' => 'Usuario',
            'password' => 'Password',
            'fechaCreacion' => 'Fecha Creacion',
            'activo' => 'Activo',
        ];
    }
}
