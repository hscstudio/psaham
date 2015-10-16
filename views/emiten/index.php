<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emiten-index">

    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>
    <!-- <div class="ui divider"></div> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
      'id'=>'pjax-gridview',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns'=>true,
        //'showPageSummary'=>true,
        'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> </h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-2 col-lg-1">'.
              Html::a('Create', ['create'], ['class' => 'btn btn-success']).' '.
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.

              '</div>'.
            '</div>',
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
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
              'attribute' => 'KODE',
              'label' => 'Kode',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'NAMA',
              'label' => 'Nama',
              'options' => [
                  //'width' => '180px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'left',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'JMLLOT',
              'label' => 'Jml Lot',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'JMLSAHAM',
              'label' => 'Jml Saham',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'SALDO',
              'label' => 'Saldo',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'HARGA',
              'label' => 'Harga',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'SALDOR1',
              'label' => 'Saldo R1',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'JMLLOTB',
              'label' => 'Jml LotB',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'attribute' => 'SALDOB',
              'label' => 'Saldo B',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],

            [
              'class' => 'kartik\grid\ActionColumn',
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
