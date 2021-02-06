<?php

namespace app\models;

use Yii;
use app\models\Moneda;
/**
 * This is the model class for table "tasa".
 *
 * @property int $idTasa
 * @property int $idMoneda
 * @property float $tasaActual
 * @property int $idUsuario
 * @property bool $activo
 *
 * @property Monedas $idMoneda0
 * @property Usuarios $idUsuario0
 */
class Tasa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idMoneda', 'idUsuario','tasaActual'], 'required'],
            [['idMoneda', 'idUsuario'], 'integer'],
            [['tasaActual'], 'number'],
            [['fechaOperacion'], 'safe'],
            [['activo'], 'boolean'],
            [['idMoneda'], 'exist', 'skipOnError' => true, 'targetClass' => Moneda::className(), 'targetAttribute' => ['idMoneda' => 'idMoneda']],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idTasa' => 'Id',
            'idMoneda' => 'Moneda',
            'tasaActual' => 'Tasa Actual',
            'fechaOperacion' => 'Fecha',
            'idUsuario' => 'Usuario',
            'activo' => 'Activo',
        ];
    }

    /**
     * Gets query for [[IdMoneda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoneda()
    {
        return $this->hasOne(Moneda::className(), ['idMoneda' => 'idMoneda']);
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
}
