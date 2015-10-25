<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pembelian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-index">
    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>
    <!-- <div class="ui divider"></div> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
  		'id'=>'pjax-gridview',
  	]); ?>
    <?php
    $total_lot = 1;
    ?>
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-shopping-cart"></i> <span class="hidden-xs">Tanggal</span> transaksi terakhir '.(($latestDate[1]==1)?'belum ada':$latestDate[1]).'</h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-2 col-lg-1">'.
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create','date'=> $dates[1]], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              'data-target'=>"#myModal",
              'data-title'=>"Create Data",
              'data-size'=>"modal-lg",
              ]):'').' '.
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.
              DatePicker::widget([
                  'name' => 'grid_date',
                  'value' => $dates[1],
                  'removeButton' => false,
                  'options' => [
                    'placeholder' => 'Tgl Grid ...',
                  ],
                  'readonly' => true,
                  'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'format' => 'dd-M-yyyy',
                    'autoclose'=>true,
                    'buttonClose'=>false,
                  ],
                  'pluginEvents' => [
                      "changeDate" => "function(e) {
                          $.pjax.reload({
            								url: '".Url::to(['index'])."?date='+e.format(0,'yyyy-m-d'),
            								container: '#pjax-gridview',
            								timeout: 1,
            							});
                      }",
                  ]
              ]).
              '</div>'.
            '</div>',
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','date'=>$dates[1]], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            //'{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
              'attribute' => 'TGL',
              'header' => 'Tanggal',
              'filter' => false,
              'format' => ['date','php:d M Y'],
              'options' => [
                  'width' => '125px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'NOMOR',
              'label' => 'Nomor',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
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
              'attribute' => 'SECURITAS_KODE',
              'label' => 'Securitas',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
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
              'attribute' => 'KOM_BELI',
              'label' => 'Komisi',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'value' => function($data) {
                  $bruto = $data->JMLSAHAM * $data->HARGA;
                  $netto = $data->KOM_BELI * $bruto;
                  return $netto;
              },
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'header' => 'Total',
              'format'=>['decimal',2],
              'value' => function($data) {
                  $bruto = $data->JMLSAHAM * $data->HARGA;
                  $netto = $bruto - $data->KOM_BELI * $bruto;
                  return $netto;
              },
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            //'KOM_BELI',
            [
              'class' => 'kartik\grid\ActionColumn',
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'options' => [
                  'width' => '100px',
              ],
              'template' => Mimin::filterTemplateActionColumn(['update','delete'],$this->context->route),
              'buttons' => [
                  'update' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-pencil"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs',
                      'data-pjax'=>'0',
                      'data-toggle'=>"modal",
                      'data-target'=>"#myModal",
                      'data-title'=>"Update Data",
                      'data-size'=>"modal-lg",
                    ]);
                  },
                  'delete' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-trash"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs',
                      'data-confirm'=>"Apakah anda mau menghapus data ini?",
                      'data-method'=>'post',
                    ]);
                  },
              ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
