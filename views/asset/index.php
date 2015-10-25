<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create'], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              //'data-target'=>"#myModal",
              'data-title'=>"Create Data",
              //'data-size'=>"modal-lg",
              ]):'').' '.
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
            'TGL',
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
                      'data-title'=>"View Data",
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

</div>
