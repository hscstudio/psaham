<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamfundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paramfunds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paramfund-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns'=>true,
        'showPageSummary'=>true,
        'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span>'.'</h3>',
            //'type'=>'primary',
            'before'=>
              Html::a('Create', ['create'], ['class' => 'btn btn-success']).' '
            ,
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','date'=>$dates[1]], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
              'attribute' => 'EMITEN_KODE',
              'label' => 'Emiten',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'TAHUN',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'TRIWULAN',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            'CE',
            'CA',
            'TA',
            'TE',
            'CL',
            'TL',
            //'BV',
            //'P_BV',
            // 'EPS',
            // 'P_EPS',
            // 'PBV',
            // 'PER',
            // 'DER',
            // 'SHARE',
            // 'HARGA',


            // 'SALES',
            // 'NI',
            // 'ROE',
            // 'ROA',
            // 'P_TE',
            // 'P_SALES',
            // 'P_NI',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
