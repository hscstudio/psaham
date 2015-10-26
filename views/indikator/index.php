<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IndikatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Indikators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indikator-index">

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
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create','tgl'=>date('Y-m-d',strtotime($searchModel->TGL))], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              'data-target'=>"#myModal",
              'data-title'=>"Create Data",
              //'data-size'=>"modal-lg",
              ]):'').' '.
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.

              '</div>'.
            '</div>',
        ],
        'toolbar' => [
            //['content'=>
                //Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            //],
            //ButtonExport::widget(),
            //'{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
              'attribute' => 'NAMA',
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'left',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'NAVAT',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'NAV',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            [
              'attribute' => 'TUMBUH',
              'format'=>['decimal',2],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
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
                      'data-toggle'=>"modal",
                      'data-target'=>"#myModal",
                      'data-title'=>"Update Data",
                    ]);
                  },
                  'delete' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-trash"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs pjax-delete',
                      'data-pjax-container' => 'pjax-gridview',
                      'data-confirm-message' => 'Yakin akan menghapus data ini?',
                    ]);
                  },
              ]
            ],
        ],
    ]); ?>

    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::init($this);
    }
    ?>

    <?php
    $this->registerJs("
      $('.pjax-delete').on('click', function (e) {
        e.preventDefault();
        var deleteUrl     = $(this).attr('href');
        var pjaxContainer = $(this).attr('data-pjax-container');
        var confirmMessage = $(this).attr('data-confirm-message');
        result = confirm(confirmMessage);
        if (result) {
            $.ajax({
              url:   deleteUrl,
              type:  'post',
              error: function (xhr, status, error) {
                alert('There was an error with your request.'
                      + xhr.responseText);
              }
            }).done(function (data) {
              $.pjax.reload('#pjax-indikator', {
                url: '".Url::to(['indikator/index','tgl'=>date('Y-m-d',strtotime($model->TGL))])."',
                container: '#pjax-indikator',
                timeout: 3000,
                push: false,
                replace: false
              });
            });
        }
        false;
      });

    ");
    ?>
    <?php Pjax::end(); ?>
</div>
