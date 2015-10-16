<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paramfund */

$this->title = 'Update Paramfund: ' . ' ' . $model->EMITEN_KODE;
$this->params['breadcrumbs'][] = ['label' => 'Paramfunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EMITEN_KODE, 'url' => ['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paramfund-update">

  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Input data parameter </p>
  </div>
  <div class="ui divider"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
