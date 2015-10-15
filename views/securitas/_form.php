<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Securitas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="securitas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
        <?= $form->field($model, 'KODE')->textInput(['maxlength' => true]) ?>
      </div>
    </div>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
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
      <div class="col-xs-6 col-sm-4 col-md-3">
      <?= $form->field($model, 'HP')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
      <?= $form->field($model, 'CP')->textInput(['maxlength' => true])->label('Contact Person') ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
          'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
          'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
