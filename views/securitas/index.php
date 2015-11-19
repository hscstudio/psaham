<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use hscstudio\mimin\components\Mimin;
use hscstudio\export\widgets\ButtonExport;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SecuritasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Securitas';
$this->params['breadcrumbs'][] = $this->title;
/*
$permission = '/'.$this->context->id.'/create';
echo $permission."<br>";
$pos = (strrpos($permission, '/'));
$parent = substr($permission, 0, $pos);
echo $parent;
*/
?>
<div class="securitas-index">
    <!-- <div class="ui divider"></div> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
      'id'=>'securitas-index-pjax',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap'=>true,
        'hover'=>true,
        'resizableColumns' => false,
        //'showPageSummary'=>true,
        'showFooter'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <span class="hidden-xs"></span> '.Html::encode($this->title).'</h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-2 col-lg-1">'.
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create'], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              'data-target'=>"#myModal",
              'data-title'=>"Create Data Securitas",
              ]):'').' '.
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.

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
            //'{toggleData}',
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
              'attribute' => 'ALAMAT',
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
              'attribute' => 'TELP',
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
              'attribute' => 'HP',
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
              'attribute' => 'CP',
              'label' => 'Kontak',
              'options' => [
                  'width' => '140px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'left',
              'vAlign'=>'middle',
            ],
            // 'HP',

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
                      'data-title'=>"View Data Securitas",
                    ]);
                  },
                  'update' => function ($url, $model) {
                    $icon='<span class="glyphicon glyphicon-pencil"></span>';
                    return Html::a($icon,$url,[
                      'class'=>'btn btn-default btn-xs',
                      'data-pjax'=>'0',
                      'data-toggle'=>"modal",
                      'data-target'=>"#myModal",
                      'data-title'=>"Update Data Securitas",
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
