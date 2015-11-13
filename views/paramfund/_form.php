<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Emiten;
use yii\widgets\MaskedInput;
use app\components\GrowlLoad;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Paramfund */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paramfund-form">
  <?php Pjax::begin([
    'id' => 'paramfund-form-pjax',
    'enablePushState' => false,
  ]); ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true ],
        'enableClientValidation' => false,
      ]); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
      <?= $form->field($model, 'TAHUN')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-xs-6 col-sm-3">
      <?= $form->field($model, 'TRIWULAN')->widget(Select2::classname(), [
        'data' => ['I'=>'I','II'=>'II','III'=>'III','IV'=>'IV'],
        'options' => [
          'placeholder' => 'Pilih Triwulan ...',
          'disabled'=>(!$model->isNewRecord)?true:false,
        ],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        $data = ArrayHelper::map(
          Emiten::find()
            ->select([
              'KODE','NAMA', 'DERIVED' => 'CONCAT(KODE," - ",NAMA)'
            ])
            ->asArray()
            ->all(), 'KODE', 'KODE');

        echo $form->field($model, 'EMITEN_KODE')->widget(Select2::classname(), [
          'data' => $data,
          'options' => [
            'placeholder' => 'Pilih Emiten ...',
            'onchange'=>'
              $.post( "'.Url::to(['get-emiten']).'?id="+$(this).val(), function( data ) {
                $( "#emiten-name" ).val( data.data.NAMA );
                $( "#emiten-name" ).focus();
              });
            ',
            'disabled'=>(!$model->isNewRecord)?true:false,
          ],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]); ?>
      </div>
      <div class="col-xs-6 col-sm-9">
        <label class="control-label">Nama Emiten</label>
        <?php
        $emiten_name = ($model->emiten)?$model->emiten->NAMA:'';
        ?>
        <?= Html::input('text', 'emiten_name', $emiten_name, [
            'class' => 'form-control',
            'id'=> 'emiten-name',
            'readonly'=> 'true'
        ]) ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'CE')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'CA')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'TA')->widget(MaskedInput::classname(),[
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
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'TE')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'CL')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'TL')->widget(MaskedInput::classname(),[
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

    <hr>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'SALES')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'NI')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'EPS')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'PER')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'HARGA')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'BV')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'PBV')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'SHARE')->widget(MaskedInput::classname(),[
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
      <div class="col-xs-6 col-sm-3">
        <?php
        echo $form->field($model, 'DER')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'ROE')->widget(MaskedInput::classname(),[
            'clientOptions' => [
                'alias' =>  'numeric',
                'groupSeparator' => ',',
                'radixPoint' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' =>true,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'ROA')->widget(MaskedInput::classname(),[
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


    <!-- AUTOMATIC FIELD
      <?= $form->field($model, 'P_BV')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'P_EPS')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'P_TE')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'P_SALES')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'P_NI')->textInput(['maxlength' => true]) ?>
    -->

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

    <?php ActiveForm::end(); ?>
    <?php $this->registerJs('
      $("#paramfund-tahun").focus();
      $("#paramfund-form-pjax").on("pjax:end", function() {
          $.pjax.reload("#paramfund-index-pjax", {
            url: "'.Url::to(["index"]).'",
            container: "#paramfund-index-pjax",
            timeout: 3000,
            push: false,
            replace: false
          });
      });


    ') ?>
    <?php
    if(Yii::$app->request->isAjax){
      AlertBlock::widget(Yii::$app->params['alertBlockConfig']);
      GrowlLoad::init($this);
    }
    ?>
  <?php Pjax::end(); ?>

</div>
