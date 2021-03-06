<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paramfund */

$this->title = 'Update : ' . ' ' . $model->EMITEN_KODE;
$this->params['breadcrumbs'][] = ['label' => 'Parameter Fundamental', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EMITEN_KODE, 'url' => ['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paramfund-update">
  <?php if (!Yii::$app->request->isAjax){ ?>
  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Input data parameter </p>
  </div>
  <div class="ui divider"></div>
  <?php } ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
