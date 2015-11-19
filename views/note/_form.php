<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;
use yii\helpers\Url;

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
      'options' => ['data-pjax' => true ],
      'enableClientValidation' => false,
      ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 8]) ?>


    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
          'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
          'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
      ]) ?>
        <?= Html::a('Close',['index'],[
            'class'=>'btn btn-default',
            'onclick'=>'
              if (confirm("Apakah yakin mau keluar dari halaman ini?")) {
                  $("#myModal").modal("hide");
                  return false;
              }
              else{
                return false;
              }
            '
        ]) ?>
    </div>
    <?php $this->registerJs('
      $("#note-title").focus();
      $("#note-form-pjax").on("pjax:end", function() {
          $.pjax.reload("#note-index-pjax", {
            url: "'.Url::to(["index"]).'",
            container: "#note-index-pjax",
            timeout: 3000,
            push: false,
            replace: false
          });
          setTimeout(function() {
            $("#note-title").focus();
          },3000)
      });
    ') ?>

    <?php ActiveForm::end(); ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::reload($this);
    }
    ?>
    <?php Pjax::end(); ?>
</div>
