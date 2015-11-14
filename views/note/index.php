<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="note-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
      'id'=>'note-index-pjax',
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover'=>true,
        //'showPageSummary'=>true,
        //'showFooter'=>false,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-file"></i> <span class="hidden-xs"></span> '.Html::encode($this->title).'</h3>',
            //'type'=>'primary',
            'before'=>
            '<div class="row">'.
              '<div class="col-xs-2 col-lg-1">'.
              ((Mimin::filterRoute($this->context->id.'/create'))?Html::a('Create', ['create'], ['class' => 'btn btn-success',
              'data-pjax'=>'0',
              'data-toggle'=>"modal",
              'data-target'=>"#myModal",
              'data-title'=>"Create Data Note"
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
            //'{export}',
            //'{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'id',
            'title',
            //'content:ntext',
            [
              'attribute' => 'content',
              'format' => 'ntext',
              'value' => function($data){
                return substr($data->content,0,150).'...';
              }
            ],
            [
              'attribute' => 'updated_at',
              'label' => 'Last Update',
              'filter' => false,
              'format' => ['date','php:d M Y H:i:s'],
              'options' => [
                  'width' => '125px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'template' => Mimin::filterTemplateActionColumn(['update','delete','download'],$this->context->route),
              'buttons' => [
                'view' => function ($url, $model) {
                  $icon='<span class="glyphicon glyphicon-eye-open"></span>';
                  return Html::a($icon,$url,[
                    'class'=>'btn btn-default btn-xs',
                    'data-pjax'=>'0',
                    'data-toggle'=>"modal",
                    'data-target'=>"#myModal",
                    'data-title'=>"View Data Note",
                  ]);
                },
                'update' => function ($url, $model) {
                  $icon='<span class="glyphicon glyphicon-pencil"></span>';
                  return Html::a($icon,$url,[
                    'class'=>'btn btn-default btn-xs',
                    'data-pjax'=>'0',
                    'data-toggle'=>"modal",
                    'data-target'=>"#myModal",
                    'data-title'=>"Update Data Note",
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
                'download' => function ($url, $model) {
                  $icon='<span class="glyphicon glyphicon-download"></span>';
                  return Html::a($icon,$url,[
                    'class'=>'btn btn-default btn-xs',
                    'data-pjax'=>'0',
                    'data-title'=>"Download file sebagai text",
                  ]);
                },
              ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
