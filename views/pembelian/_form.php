<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use Zelenin\yii\SemanticUI\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Emiten;
use app\models\Securitas;
use app\components\JsBlock;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Pembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembelian-form">

  <?php Pjax::begin([
      'id' => 'pembelian-form-pjax',
      'enablePushState' => false,
    ]); ?>
      <?php $form = ActiveForm::begin([
        'id' => 'pembelian-form',
        'options' => ['data-pjax' => true ],
        'enableClientValidation' => false,
      ]); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
      <?= $form->field($model, 'NOMOR')->textInput([
        'maxlength' => true,
        'readonly' => true,
        'style'=>'text-align:center;'
      ]) ?>
      </div>
      <div class="col-xs-6 col-sm-3 col-sm-offset-6 ">
      <?= $form->field($model, 'TGL')->widget(DatePicker::classname(), [
          'options' => ['placeholder' => 'Tgl Transaksi ...'],
          'readonly' => true,
          'removeButton' => false,
          'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'format' => 'dd-M-yyyy',
            'autoclose'=>true,
          ]
      ]); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        $data = ArrayHelper::map(
          Emiten::find()
            ->select([
              'KODE','NAMA', 'DERIVED' => 'CONCAT(KODE," - ",NAMA)'
            ])
            ->asArray()
            ->all(), 'KODE', 'KODE');

        echo $form->field($model, 'EMITEN_KODE')->widget(Select2::classname(), [
          'data' => $data,
          'options' => [
            'placeholder' => 'Pilih Emiten ...',
            'onchange'=>'
              //var id = Aes.Ctr.encrypt($(this).val(), "123456", 256);
              var id = $(this).val()
              $.post( "'.Url::to(['get-emiten']).'?id="+id, function( data ) {
                $( "#emiten-name" ).val( data.data.NAMA );
                $( "#emiten-name" ).focus();
              });
            ',
            'disabled'=>(!$model->isNewRecord)?true:false,
          ],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]); ?>
      </div>
      <div class="col-xs-6 col-sm-9">
        <label class="control-label">Nama Emiten</label>
        <?php
        $emiten_name = ($model->emiten)?$model->emiten->NAMA:'';
        ?>
        <?= Html::input('text', 'emiten_name', $emiten_name, [
            'class' => 'form-control',
            'id'=> 'emiten-name',
            'readonly'=> 'true'
        ]) ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        $data = ArrayHelper::map(
          Securitas::find()
            ->select([
              'KODE','NAMA', 'DERIVED' => 'CONCAT(KODE," - ",NAMA)'
            ])
            ->asArray()
            ->all(), 'KODE', 'KODE');

        echo $form->field($model, 'SECURITAS_KODE')->widget(Select2::classname(), [
          'data' => $data,
          'options' => [
            'placeholder' => 'Pilih Securitas ...',
            'onchange'=>'
              //var id = Aes.Ctr.encrypt($(this).val(), "123456", 256);
              var id = $(this).val()
              $.post( "'.Url::to(['get-securitas']).'?id="+id, function( data ) {
                $( "#securitas-name" ).val( data.data.NAMA );
                $( "#securitas-name" ).focus();
              });
            ',
          ],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]); ?>
      </div>
      <div class="col-xs-6 col-sm-9">
        <label class="control-label">Nama Securitas</label>
        <?php
        $securitas_name = ($model->securitas)?$model->securitas->NAMA:'';
        ?>
        <?= Html::input('text', 'securitas_name', $securitas_name, [
            'class' => 'form-control',
            'id'=> 'securitas-name',
            'readonly'=> 'true',
        ]) ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'JMLLOT')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ])->label('Jml Lot');
        ?>
      </div>
      <div class="col-xs-6 col-sm-6 text-center">
        <label class="control-label">Jml saham per lot</label>
        <br>
        <?= 'x'.number_format($lotshare) ?>
      </div>
      <div class="col-xs-6 col-xs-offset-6 col-sm-3 col-sm-offset-0">
        <?php
        echo $form->field($model, 'JMLSAHAM')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
      <?php
      echo $form->field($model, 'HARGA')->widget(MaskedInput::classname(),[
          'clientOptions' => [
              'alias' =>  'numeric',
              'groupSeparator' => ',',
              'radixPoint' => '.',
              'autoGroup' => 1,
              'removeMaskOnSubmit' =>true,
          ],
      ]);
      ?>
      </div>
    </div>

    <?php
    $share = $lotshare * $model->JMLLOT;
    $bruto = $share * $model->HARGA;
    // 2.	Perhitungan Total Komisi = kom_beli * harga * share / 100
    $komisi_total = $model->KOM_BELI * $bruto / 100;

    // 1.	Koreksi perhitungan total. Total = (jmlsaham * harga) + total komisi
    $netto = $bruto + $komisi_total;
    ?>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'KOM_BELI')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ])->label('Komisi');
        ?>
      </div>
      <div class="col-xs-6 col-sm-6">

        <label class="control-label">Total Komisi</label>
        <?= Html::input('text', 'komisi-total', number_format($komisi_total,2), [
            'class' => 'form-control',
            'id'=> 'komisi-total',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
      </div>
      <div class="col-xs-6 col-xs-offset-6 col-sm-3 col-sm-offset-0">
        <label class="control-label">Harga Total</label>
        <?= Html::input('text', 'harga-total', number_format($netto,2 ), [
            'class' => 'form-control',
            'id'=> 'harga-total',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
        <?php
        echo $form->field($model, 'TOTAL_BELI')->hiddenInput()->label();
        ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ]) ?>
        <?= Html::a('Close',['index','date' =>date('Y-m-d',strtotime($model->TGL))],[
            'class'=>'btn btn-default',
            'onclick'=>'
              if (confirm("Apakah yakin mau keluar dari halaman ini?")) {
                  $("#myModal").modal("hide");
                  return false;
              }
              else{
                return false;
              }
            '
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::init($this);
    }
    ?>
    <?php
    if($model->isNewRecord){
      $this->registerJs('
        //$("#pembelian-emiten_kode").select2("focus");
      ');
    }
    else{
      $this->registerJs('
        //$("#pembelian-securitas_kode").focus();
      ');
    }
    ?>

    <?php
    $this->registerJs('
      $("#pembelian-form-pjax").on("pjax:end", function() {
          $.pjax.reload("#pembelian-index-pjax", {
            url: "'.Url::to(["index",'date'=>date('Y-m-d',strtotime($model->TGL))]).'",
            container: "#pembelian-index-pjax",
            timeout: 3000,
            push: false,
            replace: false
          });
      });

      $("#pembelian-jmllot").bind("change", function(){
          // Jika jmllot diisi maka share = jmllot * jmllbrsaham.
          jmllot = accounting.unformat($("#pembelian-jmllot").val());
          share = jmllot * '.$lotshare.';
          $("#pembelian-jmlsaham").val( accounting.formatNumber(share, 2)  );
          changeInput();
      });

      $("#pembelian-jmlsaham").bind("change", function(){
          //Jika share diisi maka jmllot = share / jmllbrsaham.
          share = accounting.unformat($("#pembelian-jmlsaham").val());
          jmllot = share / '.$lotshare.';
          $("#pembelian-jmllot").val( accounting.formatNumber(jmllot, 2)  );
          changeInput();
      });

      $("#pembelian-harga, #pembelian-kom_beli ").bind("change", function(){
          changeInput();
      });

      function changeInput(){
          jmllot = accounting.unformat($("#pembelian-jmllot").val());
          jmlsaham = accounting.unformat($("#pembelian-jmlsaham").val());
          harga = accounting.unformat($("#pembelian-harga").val());
          komisi = accounting.unformat($("#pembelian-kom_beli").val());


          share = '.$lotshare.'* jmllot;
          bruto = share * harga
          // 2.	Perhitungan Total Komisi = kom_beli * harga * share / 100
          komisi_total = komisi * bruto / 100;

          // 1.	Koreksi perhitungan total. Total = (jmlsaham * harga) + total komisi
          netto = bruto + komisi_total;

          $("#komisi-total").val( accounting.formatNumber(komisi_total, 2) );
          $("#harga-total").val( accounting.formatNumber(netto, 2) );
          $("#pembelian-total_beli").val( netto);
      }
    ');
    ?>

  <?php Pjax::end(); ?>
</div>
