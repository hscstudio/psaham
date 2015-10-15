<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SecuritasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="securitas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'KODE') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?= $form->field($model, 'ALAMAT') ?>

    <?= $form->field($model, 'TELP') ?>

    <?= $form->field($model, 'CP') ?>

    <?php // echo $form->field($model, 'HP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
