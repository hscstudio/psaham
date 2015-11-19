<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Securitas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="securitas-form">
  <?php Pjax::begin([
      'id' => 'securitas-form-pjax',
      'enablePushState' => false,
    ]); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'securitas-form',
        'options' => ['data-pjax' => true ]
      ]); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
        <?= $form->field($model, 'KODE')->textInput(['maxlength' => true,'disabled'=>(!$model->isNewRecord)?true:false]) ?>
      </div>
    </div>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4">
      <?php
      echo $form->field($model, 'TELP')->widget(MaskedInput::classname(),[
          'mask' => '9',
          'clientOptions' => [
              'repeat' => 10,
              'greedy' => false,
              'removeMaskOnSubmit' =>true,
          ],
      ]);
      ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-4">
      <?= $form->field($model, 'HP')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-4">
      <?= $form->field($model, 'CP')->textInput(['maxlength' => true])->label('Kontak') ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
          'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
          'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ]) ?>
        <?= Html::a('Close',['index'],[
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
    <?php $this->registerJs('
      $("#securitas-kode").focus();
      $("#securitas-form-pjax").on("pjax:end", function() {
          $.pjax.reload("#securitas-index-pjax", {
            url: "'.Url::to(["index"]).'",
            container: "#securitas-index-pjax",
            timeout: 3000,
            push: false,
            replace: false
          });
          setTimeout(function() {
            $("#securitas-kode").focus()
          },3000)
      });
    ') ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::reload($this);
    }
    ?>
  <?php Pjax::end(); ?>
</div>
