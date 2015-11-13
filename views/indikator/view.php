<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Indikator */

$this->title = $model->TGL;
$this->params['breadcrumbs'][] = ['label' => 'Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indikator-view">

    <?php if (!Yii::$app->request->isAjax){ ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
              'attribute'=>'TGL',
              'format'=>['date','php:d M Y'],
            ],
            'NAMA',
            [
              'attribute'=>'NAVAT',
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
      <?= Html::a('Close',['index'],[
          'class'=>'btn btn-default',
          'onclick'=>'
            if (confirm("Apakah yakin mau keluar dari halaman ini?")) {
                $("#myModal").modal("hide");
                return false;
            }
            else{
              return false;
            }
          '
      ]) ?>
    </p>
</div>
