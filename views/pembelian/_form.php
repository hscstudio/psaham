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
/* @var $this yii\web\View */
/* @var $model app\models\Pembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembelian-form">

    <?php $form = ActiveForm::begin([
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
              $.post( "'.Url::to(['get-emiten']).'?id="+$(this).val(), function( data ) {
                $( "#emiten-name" ).val( data.data.NAMA );
                $( "#emiten-name" ).focus();
              });
            ',
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
              $.post( "'.Url::to(['get-securitas']).'?id="+$(this).val(), function( data ) {
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
        <label class="control-label">Jml Saham</label>
        <?= Html::input('text', 'saham-total', number_format($lotshare*$model->JMLLOT), [
            'class' => 'form-control',
            'id'=> 'saham-total',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
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
        <?= Html::input('text', 'komisi-total', number_format($model->KOM_BELI*($lotshare*$model->JMLLOT)*$model->HARGA), [
            'class' => 'form-control',
            'id'=> 'komisi-total',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
      </div>
      <div class="col-xs-6 col-xs-offset-6 col-sm-3 col-sm-offset-0">
        <label class="control-label">Harga Total</label>
        <?= Html::input('text', 'harga-total', number_format( ($lotshare*$model->JMLLOT)*$model->HARGA ), [
            'class' => 'form-control',
            'id'=> 'harga-total',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ]) ?>
        <?= Html::a('Cancel',['index','date' =>date('Y-m-d',strtotime($model->TGL))],['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs('

    $("#pembelian-jmllot, #pembelian-harga, #pembelian-kom_beli ").bind("change", function(){
        changeInput();
    });

    function changeInput(){
        jml_lot = accounting.unformat($("#pembelian-jmllot").val());
        harga = accounting.unformat($("#pembelian-harga").val());
        komisi = accounting.unformat($("#pembelian-kom_beli").val());
        saham_total = '.$lotshare.'* jml_lot;
        harga_total = saham_total * harga;
        komisi_total = komisi * harga_total;

        $("#saham-total").val( accounting.formatNumber(saham_total, 2) );
        $("#harga-total").val( accounting.formatNumber(harga_total, 2) );
        $("#komisi-total").val( accounting.formatNumber(komisi_total, 2) );
    }

');
?>
