<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IndikatorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indikator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?= $form->field($model, 'NAVAT') ?>

    <?= $form->field($model, 'NAV') ?>

    <?= $form->field($model, 'TUMBUH') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
