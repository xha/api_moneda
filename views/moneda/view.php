<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Moneda */

$this->title = $model->idMoneda;
$this->params['breadcrumbs'][] = ['label' => 'Monedas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="moneda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Actualizar', ['update', 'id' => $model->idMoneda], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Desactivar', ['delete', 'id' => $model->idMoneda], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idMoneda',
            'descripcion',
            'simbolo',
            'alias',
            'principal:boolean',
            'fechaCreacion',
            'idUsuario',
            'activo:boolean',
        ],
    ]) ?>

</div>
