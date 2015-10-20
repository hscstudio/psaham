<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Asset', ['update'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TGL',
            'KAS_BANK',
            'TRAN_JALAN',
            'INV_LAIN',
            'STOK_SAHAM',
            // 'HUTANG',
            // 'HUT_LANCAR',
            // 'MODAL',
            // 'CAD_LABA',
            // 'LABA_JALAN',
            // 'UNIT',
            // 'NAV',
            // 'TUMBUH',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
