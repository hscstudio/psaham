<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Indikator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indikator-form">

  <?php Pjax::begin([
    'id' => 'indikator-form-pjax',
    'enablePushState' => false,
  ]); ?>
    <?php $form = ActiveForm::begin([
      'options' => [
        'action' => ['create','tgl'=>$model->TGL],
        'data-pjax' => true,
      ]
    ]); ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <div class="row">
      <div class="col-xs-6 col-sm-4">
        <?php
        echo $form->field($model, 'NAVAT')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-4">
        <?php
        echo $form->field($model, 'NAV')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-4">
        <div class="form-group">
          <label class="control-label" for="indikator-tumbuh">Tumbuh</label>
          <?php
          echo $form->field($model, 'TUMBUH')->label(false)->hiddenInput();
          ?>
          <?= Html::input('text', 'indikator_tumbuh', number_format($model->TUMBUH,2), [
              'class' => 'form-control',
              'id'=> 'indikator_tumbuh',
              'readonly'=> 'true',
              'style'=>'text-align:right;',
          ]) ?>
          <div class="help-block"></div>
        </div>
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

    <?php
    $this->registerJs('
        $("#indikator-form-pjax").on("pjax:end", function() {
            $.pjax.reload("#pjax-indikator", {
              url: "'.Url::to(["indikator/index","tgl"=>date('Y-m-d',strtotime($model->TGL))]).'",
              container: "#pjax-indikator",
              timeout: 3000,
              push: false,
              replace: false
            });
        });
    ');

    $this->registerJs('
      // KOLOM TUMBUH
      $("#indikator-nav, #indikator-navat").bind("change", function(){
        setTumbuh()
        setNegative()
      });

      //NAV – NAV.AT)  / NAV.AT * 100
      function setTumbuh(){
        nav = accounting.unformat($("#indikator-nav").val());
        navat = accounting.unformat($("#indikator-navat").val());

        tumbuh = 0;
        if(navat>0) tumbuh = ((nav - navat) / navat);

        $("#indikator_tumbuh").val( accounting.formatNumber(tumbuh, 2) );
        $("#indikator-tumbuh").val( tumbuh );
      }

      function setNegative(){
        $("div.wrap").find("input").each(function(){
          val = $(this).val()
          first = val.substring(0, 1);
          $(this).removeClass("negative")
          if(first=="-") $(this).addClass("negative")
        });
      }

      setNegative()
    ');
    ?>
  <?php Pjax::end(); ?>
</div>
