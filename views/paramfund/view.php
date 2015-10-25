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
            'BV',
            'P_BV',
            'EPS',
            'P_EPS',
            'PBV',
            'PER',
            'DER',
            'SHARE',
            'HARGA',
            'CE',
            'CA',
            'TA',
            'TE',
            'CL',
            'TL',
            'SALES',
            'NI',
            'ROE',
            'ROA',
            'P_TE',
            'P_SALES',
            'P_NI',
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
