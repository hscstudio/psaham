<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParamfundSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paramfund-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'EMITEN_KODE') ?>

    <?= $form->field($model, 'TAHUN') ?>

    <?= $form->field($model, 'TRIWULAN') ?>

    <?= $form->field($model, 'BV') ?>

    <?= $form->field($model, 'P_BV') ?>

    <?php // echo $form->field($model, 'EPS') ?>

    <?php // echo $form->field($model, 'P_EPS') ?>

    <?php // echo $form->field($model, 'PBV') ?>

    <?php // echo $form->field($model, 'PER') ?>

    <?php // echo $form->field($model, 'DER') ?>

    <?php // echo $form->field($model, 'SHARE') ?>

    <?php // echo $form->field($model, 'HARGA') ?>

    <?php // echo $form->field($model, 'CE') ?>

    <?php // echo $form->field($model, 'CA') ?>

    <?php // echo $form->field($model, 'TA') ?>

    <?php // echo $form->field($model, 'TE') ?>

    <?php // echo $form->field($model, 'CL') ?>

    <?php // echo $form->field($model, 'TL') ?>

    <?php // echo $form->field($model, 'SALES') ?>

    <?php // echo $form->field($model, 'NI') ?>

    <?php // echo $form->field($model, 'ROE') ?>

    <?php // echo $form->field($model, 'ROA') ?>

    <?php // echo $form->field($model, 'P_TE') ?>

    <?php // echo $form->field($model, 'P_SALES') ?>

    <?php // echo $form->field($model, 'P_NI') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
