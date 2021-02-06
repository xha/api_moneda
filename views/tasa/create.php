<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tasa */

$this->title = 'Crear Tasa';
$this->params['breadcrumbs'][] = ['label' => 'Tasas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'principal' => $principal,
    ]) ?>

</div>
