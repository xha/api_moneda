<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Moneda;

/* @var $this yii\web\View */
/* @var $model app\models\Tasa */
/* @var $form yii\widgets\ActiveForm */
$id_usuario = Yii::$app->user->identity->idUsuario;
?>

<div class="tasa-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class='col-sm-9 text-center'>
            <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-save"></i> Crear' : '<i class="glyphicon glyphicon-saved"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <div class='col-sm-3 text-right'>
            Valor Seg&uacute;n: 
            <b style="border: 1px solid grey; padding: 10px 15px; border-radius: 5px; border-left: 5px solid #3c8dbc">(1) <?= $principal ?></b>
        </div>
    </div>

    <?= $form->field($model, 'idMoneda')->dropDownList(ArrayHelper::map(Moneda::find()->where(['activo' => 1, 'principal' => 0])->OrderBy('descripcion')->all(),'idMoneda', 'descripcion', 'alias'), ['prompt' => 'Seleccione']); ?>

    <?= $form->field($model, 'tasaActual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idUsuario')->hiddenInput(['value'=>$id_usuario])->label(false); ?>
    <?= $form->field($model, 'principal')->hiddenInput(['value'=>'0'])->label(false); ?>

    <?php ActiveForm::end(); ?>

</div>
