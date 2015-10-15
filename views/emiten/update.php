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

  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Lorem ipsum sit dolor amet </p>
  </div>
  <div class="ui divider"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
