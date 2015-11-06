<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Asset */

$this->title = $model->TGL;
$this->params['breadcrumbs'][] = ['label' => 'Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-view">
  <?php if (!Yii::$app->request->isAjax){ ?>
  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Data asset </p>
  </div>
  <div class="ui divider"></div>
  <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
              'attribute'=>'TGL',
              'format'=>['date','php:d M Y'],
            ],
            [
              'attribute'=>'KAS_BANK',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'TRAN_JALAN',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'INV_LAIN',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'STOK_SAHAM',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'HUTANG',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'HUT_LANCAR',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'MODAL',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'CAD_LABA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'LABA_JALAN',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'UNIT',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'NAV',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'TUMBUH',
              'format'=>['decimal','2'],
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->TGL], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>
    </p>
</div>
