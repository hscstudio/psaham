<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Emiten */

$this->title = $model->KODE;
$this->params['breadcrumbs'][] = ['label' => 'Emitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emiten-view">

  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Lorem ipsum sit dolor amet </p>
  </div>
  <div class="ui divider"></div>
    <p><?= Html::a('Cancel',['index'],['class'=>'btn btn-default']) ?></p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'KODE',
            'NAMA',
            'JMLLOT',
            'SALDO',
            'HARGA',
            'SALDOR1',
            'JMLLOTB',
            'SALDOB',
        ],
    ]) ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->KODE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->KODE], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
