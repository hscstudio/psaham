<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Emitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emiten-index">

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
            'before'=>'',
        ],
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            //'{export}',
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
              'hAlign'=>'center',
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
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
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
              'options' => [
                  'width' => '100px',
              ],
              'headerOptions' => [
                  'style' => 'text-align:center',
              ],
              'hAlign'=>'right',
              'vAlign'=>'middle',
            ],
            // 'SALDOR1',
            // 'JMLLOTB',
            // 'SALDOB',
        ],
    ]); ?>

</div>
