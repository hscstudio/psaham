<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Note */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="note-form">
  <?php Pjax::begin([
      'id' => 'note-form-pjax',
      'enablePushState' => false,
    ]); ?>
    <?php $form = ActiveForm::begin([
      'id' => 'note-form',
      'options' => ['data-pjax' => true ]
      ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 8]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::init($this);
    }
    ?>
    <?php Pjax::end(); ?>
</div>
