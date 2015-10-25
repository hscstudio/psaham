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
            'TGL',
            'KAS_BANK',
            'TRAN_JALAN',
            'INV_LAIN',
            'STOK_SAHAM',
            'HUTANG',
            'HUT_LANCAR',
            'MODAL',
            'CAD_LABA',
            'LABA_JALAN',
            'UNIT',
            'NAV',
            'TUMBUH',
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
