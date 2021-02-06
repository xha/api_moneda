<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <center>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
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

            //'idUsuario',
            'usuario',
            //'password',
            [
               'attribute' => 'fechaCreacion',
                'format' =>  ['date', 'php:d-m-Y'],
            ],
            'activo:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
