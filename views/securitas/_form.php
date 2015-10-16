<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use app\components\JsBlock;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Securitas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="securitas-form">
  <?php Pjax::begin([
      'id' => 'securitas-form-pjax',
      'enablePushState' => false,
    ]); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'securitas-form',
        'options' => ['data-pjax' => true ]
      ]); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
        <?= $form->field($model, 'KODE')->textInput(['maxlength' => true]) ?>
      </div>
    </div>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
      <?php
      echo $form->field($model, 'TELP')->widget(MaskedInput::classname(),[
          'mask' => '9',
          'clientOptions' => [
              'repeat' => 10,
              'greedy' => false,
              'removeMaskOnSubmit' =>true,
          ],
      ]);
      ?>
      </div>
      <div class="col-xs-6 col-sm-4 col-md-3">
      <?= $form->field($model, 'HP')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3">
      <?= $form->field($model, 'CP')->textInput(['maxlength' => true])->label('Contact Person') ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
          'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
          'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ]) ?>
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

<?php
if(Yii::$app->request->isAjax){
  JsBlock::begin();
  ?>
  <script>
  $('body').on('submit', 'form#securitas-form', function () {


  });
  </script>
  <?php
  JsBlock::end();
}
?>
