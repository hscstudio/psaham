<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use Zelenin\yii\SemanticUI\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Komisi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="komisi-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="six fields">
    <?= $form->field($model, 'KOM_BELI')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="six fields">
    <?= $form->field($model, 'KOM_JUAL')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="six fields">
    <?= $form->field($model2, 'JML_LBRSAHAM')->textInput(['maxlength' => true])->label('Jml Saham / Lot') ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
