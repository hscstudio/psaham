<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;
use yii\widgets\MaskedInput;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Emiten';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin([
  'id'=>'pjax-report',
]); ?>
<div class="report-emiten-index">

    <!-- <div class="ui divider"></div> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin([
      'action' => [ 'update'],
      'options' => [
        //'data-pjax' => true,
      ],
      //'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns' => false,
        'showPageSummary'=>true,
        'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> '.Html::encode($this->title).'</h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-5 col-md-4 col-md-3 col-lg-2">'.
              DatePicker::widget([
                  'name' => 'reportDate',
                  'value' => $reportDates[1],
                  'options' => [
                    'id' => 'reportDate',
                    'placeholder' => 'Tgl Emiten ...',
                  ],
                  'readonly' => true,
                  'removeButton' => false,
                  'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'format' => 'dd-M-yyyy',
                    'autoclose'=>true,
                  ],
                  'pluginEvents' => [
                    "changeDate" => "function(e) {
                        changeDate(e.format(0,'yyyy-m-d'))
                    }",
                  ]
              ]).
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.

              '</div>'.
            '</div>',
            'after'=>
              Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', ['class' => 'btn btn-success']).' '.
              Html::a('<i class="glyphicon glyphicon-trash"></i> Hapus', ['delete','date'=>$reportDates[1]], [
                'class' => 'btn btn-danger','data-method'=>'post','data-pjax'=>'0','data-confirm'=>'Apakah data akan dihapus?'
              ]).' '
            ,
            'footer'=>false
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            ButtonExport::widget(),
            //'{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
              'attribute' => 'EMITEN_KODE',
              'label' => 'Kode',
              'filter' => false,
              'format'=>'raw',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'value' => function($data){
                return Html::a($data->EMITEN_KODE,'',[
                  'onclick'   => 'setFromGridview($(this)); return false;',
                  'data-pjax' => '0',
                ]);
              },
            ],
            [
              'attribute' => 'JMLLOT',
              'label' => 'Jml Lot',
              'filter' => false,
              'format'=>['decimal',2],
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',

            ],

            [
              'attribute' => 'JMLSAHAM',
              'label' => 'Jml Saham',
              'filter' => false,
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
              'label' => 'Range Beli',
              'format'=>['decimal',2],
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                // Range Beli = saldob / (jmllotb * jmllbrsaham) -> Ket:  saldob, jmllotb dr detemiten; jmllbrsaham dr lotshare.
                //koreksi: Range Beli = saldob / jmlsahamb -> Ket:  saldob, jmlsahamb dr detemiten.
                $range_beli = (float) @($data->SALDOB / $data->JMLSAHAMB);
                return $range_beli;
              },
              //'footer'=>true
            ],
            [
              'label' => 'Range',
              'format'=>['decimal',2],
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                //Range = saldo / jmlsaham.
                $range =  (float) @($data->SALDO / $data->JMLSAHAM);
                return $range;
              },
              //'footer'=>true
            ],
            [
              'attribute' => 'SALDO',
              'label' => 'Saldo',
              'filter' => false,
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
              'filter' => false,
              'format' => 'raw',
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function ($data){
                return MaskedInput::widget([
                    'name' => 'harga['.$data->EMITEN_KODE.']',
                    'value' => number_format($data->HARGA,2),
                    'clientOptions' => [
                        'alias' =>  'numeric',
                        'groupSeparator' => ',',
                        'radixPoint' => '.',
                        'autoGroup' => true,
                        'removeMaskOnSubmit' =>true,
                    ],

                ]);
              },
            ],
            [
              'attribute' => 'TGLAKHIR',
              'label' => 'Tgl Akhir',
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'label' => 'Saldo **)',
              'format'=>['decimal',2],
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                //Saldo**) = jmlsaham * harga
                $saldo =  $data->HARGA * $data->JMLSAHAM;
                return $saldo;
              },
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              //'footer'=>true
            ],
            [
              'label' => '(+) %',
              'format'=>['decimal',2],
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data)use($total_saldo){
                //persen = (jmlsaham * harga) * 100 / totalsaldo
                $persen =  (float) @(($data->JMLSAHAM * $data->HARGA * 100) / $total_saldo);
                return $persen;
              },
              'footer'=>'Total Laba/Rugi'
            ],
            [
              'label' => 'Laba(+) / Rugi(-)',
              'format'=>['decimal',2],
              'filter' => false,
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
              'value' => function($data){
                //laba/rugi = (jmlsaham * harga) - saldo
                $laba_rugi =  ($data->JMLSAHAM * $data->HARGA) - $data->SALDO;
                return $laba_rugi;
              },
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              'footer'=>number_format($total_laba_rugi,2)
            ],

        ],
    ]); ?>
    <?php ActiveForm::end(); ?>

    <div class="row">
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Simulasi Pembelian &amp; Penjualan Saham</h3>
          </div>
          <div class="panel-body">
            <?php $form = ActiveForm::begin([
              'options' => ['data-pjax' => true ],
              //'type' => ActiveForm::TYPE_HORIZONTAL,
            ]); ?>

            <div>
              <?= $form->field($simulation, 'tipe')->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                  'onText' => 'Pembelian',
                  'offText' => 'Penjualan',
                ]
              ])->label('Pilih tipe simulasi') ?>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="row">
                  <div class="col-xs-6">
                    <?php
                    echo $form->field($simulation, 'jml_lot')->widget(MaskedInput::classname(),[
                        'clientOptions' => [
                            'alias' =>  'numeric',
                            'groupSeparator' => ',',
                            'radixPoint' => '.',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' =>true,
                        ],
                    ]);
                    ?>
                  </div>
                  <div class="col-xs-6">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <?php
                    echo $form->field($simulation, 'harga')->widget(MaskedInput::classname(),[
                        'clientOptions' => [
                            'alias' =>  'numeric',
                            'groupSeparator' => ',',
                            'radixPoint' => '.',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' =>true,
                        ],
                    ]);
                    ?>
                  </div>
                  <div class="col-xs-6">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="control-label" for="dynamicmodel-komisi">Komisi %</label>
                      <?= Html::input('text', 'DynamicModel[komisi]', '0.00', [
                          'class' => 'form-control',
                          'id'=> 'dynamicmodel-komisi',
                          'readonly'=> 'true',
                          'style'=>'text-align:right;',
                      ]) ?>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label class="control-label" for="dynamicmodel-total_komisi">Total Komisi</label>
                      <?= Html::input('text', 'DynamicModel[total_komisi]', '0.00', [
                          'class' => 'form-control',
                          'id'=> 'dynamicmodel-total_komisi',
                          'readonly'=> 'true',
                          'style'=>'text-align:right;',
                      ]) ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <?php
                  echo $form->field($simulation, 'jml_saham')->widget(MaskedInput::classname(),[
                      'clientOptions' => [
                          'alias' =>  'numeric',
                          'groupSeparator' => ',',
                          'radixPoint' => '.',
                          'autoGroup' => true,
                          'removeMaskOnSubmit' =>true,
                      ],
                  ]);
                  ?>
                </div>
                <div class="form-group">
                  <label class="control-label" for="dynamicmodel-range">Range</label>
                  <?= Html::input('text', 'DynamicModel[range]', '0.00', [
                      'class' => 'form-control',
                      'id'=> 'dynamicmodel-range',
                      'readonly'=> 'true',
                      'style'=>'text-align:right;',
                  ]) ?>
                </div>
                <div class="form-group">
                  <label class="control-label" for="dynamicmodel-total_harga">Total Harga</label>
                  <?= Html::input('text', 'DynamicModel[total_harga]', '0.00', [
                      'class' => 'form-control',
                      'id'=> 'dynamicmodel-total_harga',
                      'readonly'=> 'true',
                      'style'=>'text-align:right;',
                  ]) ?>
                </div>
              </div>
            </div>
            <?php ActiveForm::end(); ?>
            Ket: <br>
            - Sebelum/sesudah melakukan simulasi, klik kode emiten pada tabel diatas
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Tanggal</h3>
          </div>
          <div class="panel-body">
            <?= Html::listBox('detemitenDates', $reportDates[1], $detemitenDates, [
              'class'=>'form-control',
              'id' => 'detemitenDates',
              'style'=> 'height:275px',
            ]) ?>
          </div>
        </div>
      </div>
    </div>

    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::reload($this);
    }
    ?>
</div>
<?php
$this->registerJs("
  $('#detemitenDates').bind('change', function(){
      changeDate($(this).val());
  });

  function changeDate(date){
    if(confirm('Apakah Anda yakin mengubah Tanggal ini?')){
      $.pjax.reload({
        url: '".Url::to(['index'])."?date='+date,
        container: '#pjax-report',
        timeout:0,
      });
    }
    else{
      $.pjax.reload({
        url: '".Url::to(['index'])."?date=".$reportDates[1]."',
        container: '#pjax-report',
      });
    }
  }

  simulate(1)

  $('#dynamicmodel-tipe').on('switchChange.bootstrapSwitch', function(event, state) {
    tipe = state;
    simulate(1)
  });

  $('#dynamicmodel-harga').bind('change', function(){
      simulate(0)
  });

  $('#dynamicmodel-jml_lot').bind('change', function(){
      simulate(1)
  });

  $('#dynamicmodel-jml_saham').bind('change', function(){
      simulate(2)
  });


");

$this->registerJs("
  var tipe = true;
  var jmlSahamG = 0;
  var saldoG = 0;
  var emitenCode = '';

  function setFromGridview(obj){
      if (typeof last_obj !== 'undefined') {
        last_obj.removeClass( 'custom-selected' );
      }
      obj.parent().parent().toggleClass( 'custom-selected' );
      last_obj = obj.parent().parent()
      //obj.find('li:nth-child(2)').html('XXX')
      jmlSahamG = accounting.unformat($('tr.custom-selected > td:nth-child(4)').html())
      saldoG = accounting.unformat($('tr.custom-selected > td:nth-child(5)').html())
      emitenCode = obj.html()
      //alert('emitenCode => '+emitenCode)
      simulate();
  }

  function simulate(x){
      harga = accounting.unformat($('#dynamicmodel-harga').val());
      kom_beli = ".$komisi->KOM_BELI.";
      kom_jual = ".$komisi->KOM_JUAL.";
      komisi = 0;
      if(tipe){ // BELI
        komisi = kom_beli;
      }
      else{
        komisi = kom_jual;
      }

      if(x==1){
        jml_lot = accounting.unformat($('#dynamicmodel-jml_lot').val());
        //jmlsaham = jmllot * jmllbrsaham dr table lotshare
        jml_saham = jml_lot * ".$lotshare->JML_LBRSAHAM.";
        $('#dynamicmodel-jml_saham').val( accounting.formatNumber(jml_saham, 2) );
      }
      if(x==2){
        jml_saham = accounting.unformat($('#dynamicmodel-jml_saham').val());
        //jmllot = jmlsaham / jmllbrsaham dr table lotshare
        jml_lot = jml_saham / ".$lotshare->JML_LBRSAHAM.";
        $('#dynamicmodel-jml_lot').val( accounting.formatNumber(jml_lot, 2) );
      }

      //Total komisi = harga * jmlsaham * komisi penjualan atau pembelian / 100
      total_komisi = harga * jml_saham * komisi / 100;

      if(tipe){ // BELI
        // Pd Simulasi pembelian :
        // total = (harga * jmlsaham) + total komisi
  		  // range = (saldo[g] + total) / (jmlsaham[g] + jmlsaham)
        total_harga = (harga * jml_saham) + total_komisi
        range = (saldoG + total_harga) / (jmlSahamG + jml_saham)
      }
      else{
        // Pd Simulasi penjualan:
        // total = (harga * jmlsaham) - total komisi
  		  // range = (saldo[g] - total) / (jmlsaham[g] - jmlsaham)
        total_harga = (harga * jml_saham) - total_komisi
        range = (saldoG - total_harga) / (jmlSahamG - jml_saham)
      }

      $('#dynamicmodel-komisi').val( accounting.formatNumber(komisi, 2) );
      $('#dynamicmodel-total_komisi').val( accounting.formatNumber(total_komisi, 2) );
      $('#dynamicmodel-total_harga').val( accounting.formatNumber(total_harga, 2) );
      $('#dynamicmodel-range').val( accounting.formatNumber(range, 2) );

      var simulate_json = {
        'tipe': tipe,
        'jml_lot':jml_lot,
        'harga':harga,
        'komisi':komisi,
        'total_komisi':total_komisi,
        'jml_saham':jml_saham,
        'range':range,
        'total_harga':total_harga,
        'emitenCode':emitenCode,
      };


      $.ajax({
        type: 'POST',
        url: '".Url::to(['set-session'])."',
        data: simulate_json,
        //contentType: 'application/json; charset=utf-8',
        dataType: 'json',
    });
  }
",\yii\web\View::POS_HEAD);
?>
<?php Pjax::end(); ?>
