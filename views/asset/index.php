<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin([
      'id'=>'pjax-gridview',
    ]); ?>
    <?php
    $this->registerJs('
      var startDate = "'.$dates[0].'";
      var endDate = "'.$dates[2].'";
    ');
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        //'responsiveWrap'=>true,
        'hover'=>true,
        //'resizableColumns'=>true,
        //'showPageSummary'=>true,
        //'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> '.Html::encode($this->title).'</h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-2 col-lg-1">'.
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create'], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              //'data-target'=>"#myModal",
              'data-title'=>"Create Data Asset",
              //'data-size'=>"modal-lg",
              ]):'').' '.
              '</div>'.
            '</div><br>'.

              '<table class="table table-condensed" style="width:50%">'.
              '<tr>'.
              '<td> start'.
              DatePicker::widget([
                  'name' => 'start',
                  'value' => $dates[1],
                  'removeButton' => false,
                  'options' => [
                    'placeholder' => 'Start ...',
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
                          startDate = e.format(0,'yyyy-m-d');
                          $.pjax.reload({
            								url: '".Url::to(['index'])."?start='+startDate+'&end='+endDate,
            								container: '#pjax-gridview',
            								timeout: 1,
            							});
                      }",
                  ]
              ]).
              '</td>'.
              '<td> <br>s.d </td>'.
              '<td> end'.
              DatePicker::widget([
                  'name' => 'end',
                  'value' => $dates[3],
                  'removeButton' => false,
                  'options' => [
                    'placeholder' => 'End ...',
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
                          endDate = e.format(0,'yyyy-m-d');
                          $.pjax.reload({
            								url: '".Url::to(['index'])."?start='+startDate+'&end='+endDate,
            								container: '#pjax-gridview',
            								timeout: 1,
            							});
                      }",
                  ]
              ]).
              '</td>'.
            '</tr>'.
            '</table>',
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
              'attribute' => 'TGL',
              'format'=>['date','php:d-M-Y'],
              'filter' => false,
              /*
              'filterType' => GridView::FILTER_DATE,
              'filterWidgetOptions' => [
                  'pluginOptions' => [
                      'format' => 'yyyy-mm-dd',
                      'autoclose' => true,
                      'todayHighlight' => true,
                  ]
              ],
              */
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'options' => [
                  'width' => '200px',
              ],
            ],
            [
              'attribute' => 'KAS_BANK',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'TRAN_JALAN',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'INV_LAIN',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'STOK_SAHAM',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            // 'HUTANG',
            // 'HUT_LANCAR',
            // 'MODAL',
            // 'CAD_LABA',
            // 'LABA_JALAN',
            // 'UNIT',
            // 'NAV',
            // 'TUMBUH',

            [
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
                      'data-title'=>"View Data Asset",
                    ]);
                  },
                  'update' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-pencil"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs',
                      'data-pjax'=>'0',
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
