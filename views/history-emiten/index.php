<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emiten-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'attribute' => 'JMLSAHAM',
              'options' => [
                  'width' => '100px',
              ],
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
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
              'vAlign'=>'middle',
              'filter' => false,
            ],
            [
              'attribute' => 'HARGA',
              'options' => [
                  'width' => '100px',
              ],
              'hAlign'=>'center',
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
