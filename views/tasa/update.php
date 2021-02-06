<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tasa */

$this->title = 'Actualizar Tasa: ' . $model->idTasa;
$this->params['breadcrumbs'][] = ['label' => 'Tasas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idTasa, 'url' => ['view', 'id' => $model->idTasa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tasa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'principal' => $principal,
    ]) ?>

</div>
