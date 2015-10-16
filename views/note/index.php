<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            /*
            [
              'attribute' => 'created_at',
              'header' => 'Dibuat',
              'filter' => false,
              'format' => ['date','php:d M Y'],
              'options' => [
                  'width' => '125px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
            ],*/
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
              'template' => '{update} {delete} {download}',
              'buttons' => [
                'view' => function ($url, $model) {
                  $icon='<span class="glyphicon glyphicon-eye-open"></span>';
                  return Html::a($icon,$url,[
                    'class'=>'btn btn-default btn-xs',
                    'data-pjax'=>'0',
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

</div>
