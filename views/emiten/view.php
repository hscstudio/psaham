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
  <?php if (!Yii::$app->request->isAjax){ ?>
  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Lorem ipsum sit dolor amet </p>
  </div>
  <div class="ui divider"></div>
  <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'KODE',
            'NAMA',
            [
              'attribute'=>'JMLLOT',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'JMLSAHAM',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'SALDO',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'HARGA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'SALDOR1',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'JMLLOTB',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'SALDOB',
              'format'=>['decimal','2'],
            ],
        ],
    ]) ?>
    <p>

        <?= Html::a('Delete', ['delete', 'id' => $model->KODE], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>

    </p>
</div>
