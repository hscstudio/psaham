<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmitenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emiten-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'KODE') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?= $form->field($model, 'JMLLOT') ?>

    <?= $form->field($model, 'JMLSAHAM') ?>

    <?= $form->field($model, 'SALDO') ?>

    <?= $form->field($model, 'HARGA') ?>

    <?php // echo $form->field($model, 'SALDOR1') ?>

    <?php // echo $form->field($model, 'JMLLOTB') ?>

    <?php // echo $form->field($model, 'SALDOB') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
