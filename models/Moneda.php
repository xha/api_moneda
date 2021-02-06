<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monedas".
 *
 * @property int $idMoneda
 * @property string $descripcion
 * @property string $simbolo
 * @property bool $principal
 * @property string $fechaCreacion
 * @property int $idUsuario
 * @property bool $activo
 *
 * @property Usuarios $idUsuario0
 * @property Tasa[] $tasas
 */
class Moneda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monedas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'idUsuario','simbolo','alias'], 'required'],
            [['principal', 'activo'], 'boolean'],
            [['fechaCreacion'], 'safe'],
            [['idUsuario'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
            [['simbolo','alias'], 'string', 'max' => 10],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idMoneda' => 'Id',
            'descripcion' => 'Descripción',
            'simbolo' => 'Símbolo',
            'alias' => 'Álias',
            'principal' => 'Principal',
            'fechaCreacion' => 'Fecha Creacion',
            'idUsuario' => 'Usuario',
            'activo' => 'Activo',
        ];
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Tasas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasas()
    {
        return $this->hasMany(Tasa::className(), ['idMoneda' => 'idMoneda']);
    }
}
