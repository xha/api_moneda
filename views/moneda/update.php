<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Moneda */

$this->title = 'Actualizar Moneda: ' . $model->idMoneda;
$this->params['breadcrumbs'][] = ['label' => 'Monedas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idMoneda, 'url' => ['view', 'id' => $model->idMoneda]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="moneda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'error' => $error,
    ]) ?>

</div>
