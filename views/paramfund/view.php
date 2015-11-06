<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paramfund */

$this->title = $model->EMITEN_KODE;
$this->params['breadcrumbs'][] = ['label' => 'Parameter Fundamental', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paramfund-view">
    <?php if (!Yii::$app->request->isAjax){ ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'EMITEN_KODE',
            'TAHUN',
            'TRIWULAN',
            [
              'attribute'=>'BV',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'P_BV',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'EPS',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'P_EPS',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'PBV',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'PER',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'DER',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'SHARE',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'HARGA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'CE',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'CA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'TA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'TE',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'CL',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'TL',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'SALES',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'NI',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'ROE',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'ROA',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'P_TE',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'P_SALES',
              'format'=>['decimal','2'],
            ],
            [
              'attribute'=>'P_NI',
              'format'=>['decimal','2'],
            ],
        ],
    ]) ?>

    <p>

        <?= Html::a('Delete', ['delete', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>

    </p>
</div>
