<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use Zelenin\yii\SemanticUI\widgets\ActiveForm;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Komisi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="komisi-form">
  <?php Pjax::begin([
    'id' => 'komisi-form-pjax',
    'enablePushState' => false,
  ]); ?>
    <?php $form = ActiveForm::begin([
      'id' => 'komisi-form',
      'options' => ['data-pjax' => true ]
      ]); ?>

    <div class="row">
      <div class="col-md-3">
      <?= $form->field($model, 'KOM_BELI')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
      <?= $form->field($model, 'KOM_JUAL')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
      <?= $form->field($model2, 'JML_LBRSAHAM')->textInput(['maxlength' => true])->label('Jml Saham / Lot') ?>
      </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    if(Yii::$app->request->isAjax){
      GrowlLoad::init($this);
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
    }
    ?>
    <?php Pjax::end(); ?>
</div>
