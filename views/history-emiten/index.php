<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;
use yii\widgets\Pjax;
use app\models\Detemiten;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Emitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emiten-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    Pjax::begin([
      'id'=>'pjax-gridview',
    ]);
    ?>

    <?php
    $dataEmitens = \yii\helpers\ArrayHelper::map(
      app\models\Emiten::find()
        ->select([
          'KODE','NAMA', 'DERIVED' => 'CONCAT(KODE," - ",NAMA)'
        ])
        ->asArray()
        ->all(), 'KODE', 'KODE');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns' => false,
        //'showPageSummary'=>true,
        'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> '.Html::encode($this->title).'</h3>',
            //'type'=>'primary',
            'before'=>'
              <div class="row">'.
                '<div class="col-xs-2 col-md-1">'.
                Html::dropDownList('per-page', $perpage, [
                  '2'  =>'2',
                  '10'  =>'10',
                  '20'  =>'20',
                  '50'  =>'50',
                  '100' =>'100',
                  'all' =>'all',
                ],[
                  'id'=>'per-page',
                  'class'=>'form-control',
                ]).
                '</div>'.
                '<div class="col-xs-6 col-md-4">'.
                \kartik\widgets\Select2::widget([
                  'name'=> 'emitens',
                  'data' => $dataEmitens,
                  'value' => $emitens,
                  'options' => [
                    'placeholder' => 'Pilih Emiten ...',
                    'onchange'=>'
                        $.pjax.reload("#pjax-gridview", {
                          url: "'.Url::to(['index']).'?emitens="+$(this).val(),
                          container: "#pjax-gridview",
                          timeout: 3000,
                          push: false,
                          replace: false
                        });
                    ',
                    //'disabled'=>(!$model->isNewRecord)?true:false,
                  ],
                  'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                  ],
                ]).
                '</div>'.

              '</div>',
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                  'data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'
                ])
            ],
            ButtonExport::widget(),
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
              'attribute' => 'JMLLOT',
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'attribute' => 'JMLSAHAM',
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'format'=>['decimal',2],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'header' => 'Range Beli',
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function ($data) use ($lotshare){
                //-	Range Beli = saldob / (jmllotb * jmllbrsaham) -> Ket:  saldob, jmllotb dr detemiten; jmllbrsaham dr lotshare.
                $detemiten = Detemiten::find()->where(['EMITEN_KODE'=>$data->KODE])->orderBy('TGL DESC')->one();
                $range_beli = (float) @($detemiten->SALDOB / ($detemiten->JMLLOTB * $lotshare));
                return number_format($range_beli,2);
                //-	Laba/Rugi = (jmlsaham * harga) - saldo

              }
            ],
            [
              'header' => 'Range',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                  //- Range = Saldo / Jml Saham
                  return @($data->SALDO / $data->JMLSAHAM);
              }
            ],
            [
              'attribute' => 'SALDO',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'attribute' => 'HARGA',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'header' => 'Tgl Akhir',
              'format' => ['date','php:d/M/Y'],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function ($data){
                //-	Range Beli = saldob / (jmllotb * jmllbrsaham) -> Ket:  saldob, jmllotb dr detemiten; jmllbrsaham dr lotshare.
                $detemiten = Detemiten::find()->where(['EMITEN_KODE'=>$data->KODE])->orderBy('TGL DESC')->one();
                if(substr($detemiten->TGLAKHIR,0,4)=='0000'){
                  return '-';
                }
                else
                  return date('d-m-Y',strtotime($detemiten->TGLAKHIR));
              }
            ],
            // - Saldo**) = Harga*) x Jml Saham
            // - Saldo**) tidak disimpan ke table emiten. Hanya merupakan info saja.
            [
              'header' => 'Saldo **)',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                  //- Range = Saldo / Jml Saham
                  return @($data->HARGA / $data->JMLSAHAM);
              }
            ],
            [
              'header' => 'Laba/Rugi',
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function ($data){
                return  ($data->JMLSAHAM * $data->HARGA) - $data->SALDO;

              }
            ],
            // 'SALDOR1',
            // 'JMLLOTB',
            // 'SALDOB',
        ],
    ]); ?>

    <?php
    $this->registerJs('
      $("#per-page").on("change", function () {
        $.pjax.reload("#pjax-gridview", {
          url: "'.Url::to(['index']).'?per-page="+$(this).val(),
          container: "#pjax-gridview",
          timeout: 3000,
          push: true,
          replace: true
        });
      });
    ');
    ?>

    <?php Pjax::end(); ?>

    <?php
    $this->registerJs('
        if(typeof(EventSource)!=="undefined") {
          var eSource = new EventSource("'.Url::to(['sse']).'?time=");
          var now = 0;
          eSource.onmessage = function(event) {
            if (event.data>now){
              $.pjax.reload("#pjax-gridview", {
                url: "'.Url::to(['index']).'",
                container: "#pjax-gridview",
                timeout: 3000,
                push: false,
                replace: false
              });
              now = event.data
            }
          };
        }
        else {
          alert("Your web browser not support auto refresh!")
        }
    ');
    ?>
</div>
