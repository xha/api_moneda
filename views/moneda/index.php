<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonedaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monedas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moneda-index">

    <center>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Crear Moneda', ['create'], ['class' => 'btn btn-success']) ?>
    </center>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model->activo == 0) return ['style' => 'background-color: #FADCAC'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idMoneda',
            'descripcion',
            'simbolo',
            'alias',
            'principal:boolean',
            //'fechaCreacion',
            //'idUsuario',
            'activo:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
