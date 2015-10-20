<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AssetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asset-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'KAS_BANK') ?>

    <?= $form->field($model, 'TRAN_JALAN') ?>

    <?= $form->field($model, 'INV_LAIN') ?>

    <?= $form->field($model, 'STOK_SAHAM') ?>

    <?php // echo $form->field($model, 'HUTANG') ?>

    <?php // echo $form->field($model, 'HUT_LANCAR') ?>

    <?php // echo $form->field($model, 'MODAL') ?>

    <?php // echo $form->field($model, 'CAD_LABA') ?>

    <?php // echo $form->field($model, 'LABA_JALAN') ?>

    <?php // echo $form->field($model, 'UNIT') ?>

    <?php // echo $form->field($model, 'NAV') ?>

    <?php // echo $form->field($model, 'TUMBUH') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
