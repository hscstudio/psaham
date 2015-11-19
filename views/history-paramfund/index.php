<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamfundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Fundamental';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paramfund-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $historyModel, 'dataProviders' => $dataProviders]); ?>

    <?php
    if(count($dataProviders)>0){
      echo '<div class="text-right"><strong>TGL & WAKTU : '.date('d-M-Y H:i:s').'</strong></div>';
      foreach ($dataProviders as $emitenCode => $dataProvider) {
          echo "<hr>";
          echo "<div style='font-weight:bold;'>Emiten: ".$emitenCode;
          if (($emitenByCode = \app\models\Emiten::find()->where(['KODE'=>$emitenCode])->asArray()->one()) !== null) {
              echo  ' ('.$emitenByCode['NAMA'].')';
          }
          echo "</div>";
          echo GridView::widget([
              'dataProvider' => $dataProvider,
              'responsive'=>true,
              'responsiveWrap'=>true,
              'hover'=>true,
              'resizableColumns' => false,
              'showPageSummary'=>true,
              'columns' => [
                  ['class' => 'kartik\grid\SerialColumn'],
                  [
                    'attribute' => 'TAHUN',
                    'options' => [
                        'width' => '75px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'TRIWULAN',
                    'options' => [
                        'width' => '75px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'SHARE',
                    'options' => [
                        'width' => '100px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'BV',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                    'pageSummary' => 'Rata-rata',
                  ],
                  [
                    'attribute' => 'P_BV',
                    'label' => '% BV',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                    'pageSummary'=>true,
                    'pageSummaryFunc'=>GridView::F_AVG,
                  ],
                  [
                    'attribute' => 'EPS',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'P_EPS',
                    'label' => '% EPS',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                    'pageSummary'=>true,
                    'pageSummaryFunc'=>GridView::F_AVG,
                  ],
                  [
                    'attribute' => 'PBV',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'PER',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'DER',
                    'options' => [
                        'width' => '80px',
                    ],
                    'hAlign'=>'center',
                    'vAlign'=>'middle',
                  ],
                  [
                    'attribute' => 'HARGA',
                    'label'=> 'Harga',
                    'options' => [
                        //'width' => '80px',
                    ],
                    'headerOptions' => [
                        'style' => 'text-align:center'
                    ],
                    'hAlign'=>'right',
                    'vAlign'=>'middle',
                  ],
              ]
            ]);
      }

      echo "<hr>";
      echo Html::a('<i class="glyphicon glyphicon-print"></i> Cetak EXCEL',['export-excel'],[
        'class'=>'btn btn-default'])." ";
      echo Html::a('<i class="glyphicon glyphicon-print"></i> Cetak PDF',['export-pdf'],[
        'class'=>'btn btn-default']);
    }
    ?>
</div>
