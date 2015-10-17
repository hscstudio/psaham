<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Emiten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emiten-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JMLLOT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JMLSAHAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SALDO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SALDOR1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JMLLOTB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SALDOB')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
