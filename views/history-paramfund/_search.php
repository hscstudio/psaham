<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Emiten;
/* @var $this yii\web\View */
/* @var $model app\models\ParamfundSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paramfund-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
    ]); ?>

    <div class="row">
        <div class="col-xs-5 col-sm-3 col-md-2">
          <?= $form->field($model, 'TAHUN_MULAI') ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-1">
          <div class="form-group text-center">
          <label class="control-label"><hr></label>
          s/d
          </div>
        </div>
        <div class="col-xs-5 col-sm-3 col-md-2">
          <?= $form->field($model, 'TAHUN_AKHIR') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-3 col-md-2">
          <?= $form->field($model, 'TRIWULAN_MULAI')->dropDownList([
            'I'=>'I','II'=>'II','III'=>'III','IV'=>'IV'
            ]) ?>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-1">
          <div class="form-group text-center">
          <label class="control-label"><hr></label>
          s/d
          </div>
        </div>
        <div class="col-xs-5 col-sm-3 col-md-2">
          <?= $form->field($model, 'TRIWULAN_AKHIR')->dropDownList([
            'I'=>'I','II'=>'II','III'=>'III','IV'=>'IV'
            ]) ?>
        </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-8 col-md-5">
        <?php
        $data = ArrayHelper::map(
          Emiten::find()
            ->select([
              'KODE','NAMA', 'DERIVED' => 'CONCAT(KODE," - ",NAMA)'
            ])
            ->asArray()
            ->all(), 'KODE', 'KODE');

        echo $form->field($model, 'EMITEN_KODES')->widget(Select2::classname(), [
          'data' => $data,
          'options' => [
            'placeholder' => 'Pilih Emiten ...',
            'onchange'=>'
              $.post( "'.Url::to(['get-emiten']).'?id="+$(this).val(), function( data ) {
                $( "#emiten-name" ).val( data.data.NAMA );
                $( "#emiten-name" ).focus();
              });
            ',
            'disabled'=>(!$model->isNewRecord)?true:false,
          ],
          'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
          ],
        ])->label('Emiten yang ingin ditampilkan'); ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Tampilkan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
