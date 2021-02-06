<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasa-index">

    <div class="row">
        <div class='col-sm-9 text-center'>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Crear Tasa', ['create'], ['class' => 'btn btn-success']) ?>    
        </div>
        <div class='col-sm-3 text-right'>
            Moneda Principal: 
            <b style="border: 1px solid grey; padding: 10px 15px; border-radius: 5px; border-left: 5px solid #3c8dbc">(1) <?= $principal ?></b>
        </div>
    </div>
    <br />
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model->activo == 0) return ['style' => 'background-color: #FADCAC'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idTasa',
            [
              'attribute'=>'idMoneda',
              'value'=>'moneda.descripcion',
            ],
            'tasaActual',
            [
               'attribute' => 'fechaOperacion',
                'format' =>  ['date', 'php:d-m-Y'],
            ],
            //'idUsuario',
            'activo:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
