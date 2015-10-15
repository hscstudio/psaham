<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NOMOR') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'JMLLOT') ?>

    <?= $form->field($model, 'HARGA') ?>

    <?= $form->field($model, 'KOM_BELI') ?>

    <?php // echo $form->field($model, 'EMITEN_KODE') ?>

    <?php // echo $form->field($model, 'SECURITAS_KODE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
