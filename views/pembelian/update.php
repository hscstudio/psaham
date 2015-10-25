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
    <?php if (!Yii::$app->request->isAjax){ ?>
    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>
    <div class="ui attached message">
      <div class="header">
        Keterangan:
      </div>
      <p>Input data pembelian </p>
    </div>
    <div class="ui divider"></div>
    <?php } ?>
    <?= $this->render('_form', [
        'model' => $model,
        'lotshare' => $lotshare,
    ]) ?>

</div>
