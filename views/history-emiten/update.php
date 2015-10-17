<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Emiten */

$this->title = 'Update Emiten: ' . ' ' . $model->KODE;
$this->params['breadcrumbs'][] = ['label' => 'Emitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->KODE, 'url' => ['view', 'id' => $model->KODE]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emiten-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
