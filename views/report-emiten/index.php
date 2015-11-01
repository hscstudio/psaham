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

    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>
    <!-- <div class="ui divider"></div> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns'=>true,
        //'showPageSummary'=>true,
        //'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> </h3>',
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
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            ButtonExport::widget(),
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
              'attribute' => 'EMITEN_KODE',
              'label' => 'Kode',
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
                    'name' => 'harga_',
                    'value' => number_format($data->HARGA,2),
                    'options' => [
                      'title' => 'Test',
                    ],
                    'clientOptions' => [
                        'alias' =>  'numeric',
                        'groupSeparator' => ',',
                        'radixPoint' => '.',
                        'autoGroup' => true,
                        'removeMaskOnSubmit' =>true,
                    ],

                ]);
              },
              'pageSummary'=>true,
              'pageSummaryFunc'=>GridView::F_SUM,
              'footer'=>true
            ],
            [
              'attribute' => 'TGLAKHIR',
              'label' => 'Tgl Akhir',
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
              'attribute' => 'JMLSAHAMB',
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

            /*[
              'class' => 'kartik\grid\ActionColumn',
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'options' => [
                  'width' => '100px',
              ],
              'template' => Mimin::filterTemplateActionColumn(['view','update','delete'],$this->context->route),
              'buttons' => [
                  'view' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-eye-open"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs',
                      'data-pjax'=>'0',
                      'data-toggle'=>"modal",
                      'data-target'=>"#myModal",
                      'data-title'=>"View Data",
                    ]);
                  },
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
            ],*/
        ],
    ]); ?>

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
                  <label class="control-label" for="dynamicmodel-jml_saham">Jml Saham</label>
                  <?= Html::input('text', 'DynamicModel[jml_saham]', '0.00', [
                      'class' => 'form-control',
                      'id'=> 'dynamicmodel-jml_saham',
                      'readonly'=> 'true',
                      'style'=>'text-align:right;',
                  ]) ?>
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
      GrowlLoad::init($this);
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
");
?>
<?php Pjax::end(); ?>
