<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SecuritasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Securitas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="securitas-index">
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
              Html::a('Create', ['create'], ['class' => 'btn btn-success']).' '.
              '</div>'.
              '<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">'.

              '</div>'.
            '</div>',
        ],
        /*
        'beforeHeader'=>[
            [
              'columns'=>[
                ['content'=>' ', 'options'=>['colspan'=>10, 'class'=>'text-center warning']],
              ],
              //'options'=>['class'=>'skip-export'] // remove this row from export
            ]
        ],
        */
        // set your toolbar
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            '{export}',
            '{toggleData}',
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
              'label' => 'Alamat / Telp.',
              'options' => [
                  //'width' => '180px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center'
              ],
              'hAlign'=>'left',
              'vAlign'=>'middle',
              'format' => 'raw',
              'value'=>function($data){
                return $data->ALAMAT.'<br>'.$data->TELP;
              }
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
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
