<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pembelian */

$this->title = 'Update Pembelian: ' . ' ' . $model->NOMOR;
$this->params['breadcrumbs'][] = ['label' => 'Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NOMOR, 'url' => ['view', 'id' => $model->NOMOR]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pembelian-update">

    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>
    <div class="ui attached message">
      <div class="header">
        Keterangan:
      </div>
      <p>Lorem ipsum sit dolor amet </p>
    </div>
    <div class="ui divider"></div>

    <?= $this->render('_form', [
        'model' => $model,
        'lotshare' => $lotshare,
    ]) ?>

</div>
