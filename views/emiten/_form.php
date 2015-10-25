<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Emiten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emiten-form">

  <?php Pjax::begin([
      'id' => 'emiten-form-pjax',
      'enablePushState' => false,
    ]); ?>
      <?php $form = ActiveForm::begin([
        'id' => 'emiten-form',
        'options' => ['data-pjax' => true ]
      ]); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?= $form->field($model, 'KODE')->textInput(['maxlength' => true,'readonly'=>$model->isNewRecord?false:true]) ?>
      </div>
    </div>
    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

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
        echo $form->field($model, 'JMLSAHAM')->label(false)->hiddenInput();
        ?>
        <label class="control-label">Jml Saham</label>
        <?= Html::input('text', 'saham-total', number_format($model->JMLSAHAM), [
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
        echo $form->field($model, 'SALDO')->widget(MaskedInput::classname(),[
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
        <div class="form-group">
        <label class="control-label">Range</label>
        <?= Html::input('text', 'range', @number_format($model->SALDO/$model->JMLSAHAM,2), [
            'class' => 'form-control',
            'id'=> 'range',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
        </div>
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
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
      </div>
      <div class="col-xs-6 col-xs-offset-6 col-sm-3 col-sm-offset-6">
        <div class="form-group">
        <label class="control-label">Saldo **)</label>
        <?= Html::input('text', 'saldo2', @number_format($model->HARGA*$model->JMLSAHAM), [
            'class' => 'form-control',
            'id'=> 'saldo2',
            'readonly'=> 'true',
            'style'=>'text-align:right;',
        ]) ?>
        </div>
      </div>
    </div>

    <!--
    AUTOMATIC
      <?= $form->field($model, 'SALDOR1')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'JMLLOTB')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'SALDOB')->textInput(['maxlength' => true]) ?>
    -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
          'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
          'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
          ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::init($this);
    }
    ?>
  <?php Pjax::end(); ?>
</div>

<?php
$this->registerJs('
  $("#emiten-jmllot, #emiten-saldo, #emiten-harga").bind("change", function(){
      changeInput();
  });

  function changeInput(){
      jml_lot = accounting.unformat($("#emiten-jmllot").val());
      saldo = accounting.unformat($("#emiten-saldo").val());
      harga = accounting.unformat($("#emiten-harga").val());

      saham_total = '.$lotshare.'* jml_lot;
      range = saldo / saham_total;
      saldo2 = harga * saham_total;

      $("#saham-total").val( accounting.formatNumber(saham_total, 2) );
      $("#range").val( accounting.formatNumber(range, 2) );
      $("#saldo2").val( accounting.formatNumber(saldo2, 2)  );

      $("#emiten-jmlsaham").val( saham_total );

  }
');
