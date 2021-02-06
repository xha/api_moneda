<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Moneda */
/* @var $form yii\widgets\ActiveForm */
$id_usuario = Yii::$app->user->identity->idUsuario;
?>

<div class="moneda-form">
    <h4><?php if ($error!="") print_r($error) ?></h4>
    <?php $form = ActiveForm::begin(); ?>

    <center>
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-save"></i> Crear' : '<i class="glyphicon glyphicon-saved"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </center>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'simbolo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activo')->dropDownList(['1' => 'SI', '0' => 'NO']); ?>

    <?= $form->field($model, 'idUsuario')->hiddenInput(['value'=>$id_usuario])->label(false); ?>
    <?= $form->field($model, 'principal')->hiddenInput(['value'=>'0'])->label(false); ?>

    <?php ActiveForm::end(); ?>

</div>
