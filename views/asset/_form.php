<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Asset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asset-form">
  <?php Pjax::begin([
    'id'=>'pjax-form',
  ]); ?>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-xs-6 col-sm-3">
      <?= $form->field($model, 'TGL')->widget(DatePicker::classname(), [
          'options' => ['placeholder' => 'Tgl Transaksi ...'],
          'readonly' => true,
          'removeButton' => false,
          'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'format' => 'dd-M-yyyy',
            'autoclose'=>true,
          ],
          'pluginEvents' => [
            "changeDate" => "function(e) {
                $.pjax.reload({
                  url: '".Url::to(['update'])."?date='+e.format(0,'yyyy-m-d'),
                  container: '#pjax-form',
                  timeout: 1,
                });
            }",
          ]
      ]); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <table class="table table-responsive table-condensed table-hover table-striped">
          <thead>
          <tr>
            <th></th>
            <th class="tgl_awal_tahun text-center"><?= '01-Jan-'.date('Y',strtotime($model->TGL)) ?></th>
            <th class="tgl_transaksi text-center"><?= $model->TGL ?></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th>Kas Bank *)</th>
            <td><?= $form->field($modelat, 'KAS_BANK')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($model, 'KAS_BANK')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
          </tr>
          <tr>
            <th>Transaksi Berjalan *)</th>
            <td><?= $form->field($modelat, 'TRAN_JALAN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($model, 'TRAN_JALAN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
          </tr>
          <tr>
            <th>Investasi Lain *)</th>
            <td><?= $form->field($modelat, 'INV_LAIN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($model, 'INV_LAIN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
          </tr>
          <tr>
            <th>Stok Saham *)</th>
            <td><?= $form->field($modelat, 'STOK_SAHAM')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($model, 'STOK_SAHAM')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
          </tr>
          <tr style="height:61px;">
            <th></th>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          </tbody>
          <tfoot>
          <tr style="border-top:2px solid #ccc;">
            <th>Aktiva *)</th>
            <td>
              <?php
              $aktivaat = $modelat->KAS_BANK + $modelat->TRAN_JALAN + $modelat->INV_LAIN + $modelat->STOK_SAHAM ;
              $aktiva = $model->KAS_BANK + $model->TRAN_JALAN + $model->INV_LAIN + $model->STOK_SAHAM ;
              ?>
              <?= Html::input('text', 'aktivaat', number_format($aktivaat,2), [
                  'class' => 'form-control',
                  'id'=> 'aktivaat',
                  'readonly'=> 'true',
                  'style'=>'text-align:right;',
              ]) ?>
            </td>
            <td>
              <?= Html::input('text', 'aktiva', number_format($aktiva,2), [
                  'class' => 'form-control',
                  'id'=> 'aktiva',
                  'readonly'=> 'true',
                  'style'=>'text-align:right;',
              ]) ?>
            </td>
          </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-responsive table-condensed table-hover table-striped input-yellow">
          <thead>
          <tr>
            <th class="tgl_transaksi text-center"><?= $model->TGL ?></th>
            <th class="tgl_awal_tahun text-center"><?= '01-Jan-'.date('Y',strtotime($model->TGL)) ?></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><?= $form->field($model, 'HUTANG')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($modelat, 'HUTANG')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <th>Hutang *)</th>
          </tr>
          <tr>
            <td><?= $form->field($model, 'HUT_LANCAR')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($modelat, 'HUT_LAIN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <th>Hutang Lancar *)</th>
          </tr>
          <tr>
            <td><?= $form->field($model, 'MODAL')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($modelat, 'MODAL')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <th>Modal *)</th>
          </tr>
          <tr>
            <td><?= $form->field($model, 'CAD_LABA')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($modelat, 'CAD_LABA')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <th>Cadangan Laba *)</th>
          </tr>
          <tr>
            <td><?= $form->field($model, 'LABA_JALAN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td><?= $form->field($modelat, 'LABA_JALAN')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <th>Laba Berjalan *)</th>
          </tr>
        </tbody>
          <tfoot>
            <tr style="border-top:2px solid #ccc;">
              <td>
                <?php
                $passivaat = $modelat->HUTANG + $modelat->HUT_LAIN + $modelat->MODAL + $modelat->CAD_LABA + $modelat->LABA_JALAN;
                $passiva = $model->HUTANG + $model->HUT_LANCAR + $model->MODAL + $model->CAD_LABA + $model->LABA_JALAN;
                ?>
                <?= Html::input('text', 'passiva', number_format($passiva,2), [
                    'class' => 'form-control',
                    'id'=> 'passiva',
                    'readonly'=> 'true',
                    'style'=>'text-align:right;',
                ]) ?>
              </td>
              <td>
                <?= Html::input('text', 'passivaat', number_format($passivaat,2), [
                    'class' => 'form-control',
                    'id'=> 'passivaat',
                    'readonly'=> 'true',
                    'style'=>'text-align:right;',
                ]) ?>
              </td>
              <th>Passiva *)</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    *) dalam jutaan

    <div class="row">
      <div class="col-md-6">
        <table class="table table-responsive table-condensed table-hover table-striped">
          <thead>
          <tr>
            <th></th>
            <th class="text-center">UNIT</th>
            <th class="text-center">NAV</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th class="tgl_awal_tahun"><?= 'Awal Tahun '.date('Y',strtotime($model->TGL)) ?></th>
            <td><?= $form->field($modelat, 'UNITAT')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td>
                <?= Html::input('text', 'navat', number_format($modelat->NAVAT,2), [
                    'class' => 'form-control',
                    'id'=> 'navat',
                    'readonly'=> 'true',
                    'style'=>'text-align:right;',
                ]) ?>
              </td>
          </tr>
          <tr>
            <th class="tgl_transaksi text-center"><?= $model->TGL ?></th>
            <td><?= $form->field($model, 'UNIT')->textInput(['maxlength' => true])->widget(MaskedInput::classname(),[
                'clientOptions' => [
                    'alias' =>  'numeric',
                    'groupSeparator' => ',',
                    'radixPoint' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' =>true,
                ],
            ])->label(false) ?></td>
            <td>
              <?= Html::input('text', 'nav', number_format($model->NAV,2), [
                  'class' => 'form-control',
                  'id'=> 'nav',
                  'readonly'=> 'true',
                  'style'=>'text-align:right;',
              ]) ?>
            </td>
          </tr>
          </tbody>
          <tfoot>
          <tr style="border-top:2px solid #ccc;">
            <th>Pertumbuhan (%)</th>
            <td>
            </td>
            <td>
              <?php
              echo $form->field($model, 'TUMBUH')->label(false)->hiddenInput();
              ?>
              <?= Html::input('text', 'tumbuh', number_format($model->TUMBUH,2), [
                  'class' => 'form-control',
                  'id'=> 'tumbuh',
                  'readonly'=> 'true',
                  'style'=>'text-align:right;',
              ]) ?>
              </td>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <?php
    echo $form->field($modelat, 'NAVAT')->label(false)->hiddenInput();
    echo $form->field($model, 'NAV')->label(false)->hiddenInput();
    ?>
    <hr>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default']) ?>
    </div>

    <hr>
    <?php Pjax::begin([
      'id'=>'pjax-indikator',
      'enablePushState'=>false,
      'enableReplaceState'=>false,
    ]); ?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
    ]); ?>
    <?php Pjax::end(); ?>

    <?php
    $this->registerJs("

      $.pjax.reload('#pjax-indikator', {
        url: '".Url::to(['indikator/index','tgl'=>date('Y-m-d',strtotime($model->TGL))])."',
        container: '#pjax-indikator',
        timeout: 3000,
        push: false,
        replace: false
      });

    ");
    ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

    <?= Html::a('<i class="glyphicon glyphicon-print"></i> Cetak EXCEL',['export-excel-detail','tgl'=>date('Y-m-d',strtotime($model->TGL))],[
      'class'=>'btn btn-default'])." "; ?>

    <?= Html::a('<i class="glyphicon glyphicon-print"></i> Cetak PDF',['export-pdf-detail','tgl'=>date('Y-m-d',strtotime($model->TGL))],[
      'class'=>'btn btn-default']) ?>
</div>

<?php
$this->registerJs('
  // KOLOM KIRI
  $("#assetat-kas_bank, #assetat-tran_jalan, #assetat-inv_lain, #assetat-stok_saham").bind("change", function(){
    setAktivateAt()
    setNavAt()
    setTumbuh()
    setNegative()
  });
  $("#asset-kas_bank, #asset-tran_jalan, #asset-inv_lain, #asset-stok_saham").bind("change", function(){
    setAktiva()
    setNav()
    setTumbuh()
    setNegative()
  });

  // KOLOM KANAN (KUNING)
  $("#assetat-hutang, #assetat-hut_lain, #assetat-modal, #assetat-cad_laba, #assetat-laba_jalan").bind("change", function(){
    setPassivaAt()
    setNavAt()
    setTumbuh()
    setNegative()
  });

  $("#asset-hutang, #asset-hut_lancar, #asset-modal, #asset-cad_laba, #asset-laba_jalan").bind("change", function(){
    setPassiva()
    setNav()
    setTumbuh()
    setNegative()
  });

  // KOLOM BAWAH
  $("#assetat-unitat").bind("change", function(){
    setNavAt()
    setTumbuh()
    setNegative()
  });

  $("#aktiva, #passiva, #asset-unit").bind("change", function(){
    setNav()
    setTumbuh()
    setNegative()
  });

  // KOLOM TUMBUH
  $("#nav, #navat, #asset-nav, #assetat-navat").bind("change", function(){
    setTumbuh()
    setNegative()
  });

  function setAktivaAt(){
    kas_bank = accounting.unformat($("#assetat-kas_bank").val());
    tran_jalan = accounting.unformat($("#assetat-tran_jalan").val());
    inv_lain = accounting.unformat($("#assetat-inv_lain").val());
    stok_saham = accounting.unformat($("#assetat-stok_saham").val());

    aktivaat = kas_bank+tran_jalan+inv_lain+stok_saham;

    $("#aktivaat").val( accounting.formatNumber(aktivaat, 2) );
  }

  function setAktiva(){
    kas_bank = accounting.unformat($("#asset-kas_bank").val());
    tran_jalan = accounting.unformat($("#asset-tran_jalan").val());
    inv_lain = accounting.unformat($("#asset-inv_lain").val());
    stok_saham = accounting.unformat($("#asset-stok_saham").val());

    aktiva = kas_bank+tran_jalan+inv_lain+stok_saham;

    $("#aktiva").val( accounting.formatNumber(aktiva, 2) );
  }

  // $passivaat = $modelat->HUTANG + $modelat->HUT_LAIN + $modelat->MODAL + $modelat->CAD_LABA + $modelat->LABA_JALAN;
  // $passiva = $model->HUTANG + $model->HUT_LANCAR + $model->MODAL + $model->CAD_LABA + $model->LABA_JALAN;

  function setPassivaAt(){
    hutang = accounting.unformat($("#assetat-hutang").val());
    hut_lain = accounting.unformat($("#assetat-hut_lain").val());
    modal = accounting.unformat($("#assetat-modal").val());
    cad_laba = accounting.unformat($("#assetat-cad_laba").val());
    laba_jalan = accounting.unformat($("#assetat-laba_jalan").val());

    passivaat = hutang+hut_lain+modal+cad_laba+laba_jalan;

    $("#passivaat").val( accounting.formatNumber(passivaat, 2) );
  }

  function setPassiva(){
    hutang = accounting.unformat($("#asset-hutang").val());
    hut_lancar = accounting.unformat($("#asset-hut_lancar").val());
    modal = accounting.unformat($("#asset-modal").val());
    cad_laba = accounting.unformat($("#asset-cad_laba").val());
    laba_jalan = accounting.unformat($("#asset-laba_jalan").val());

    passiva = hutang+hut_lancar+modal+cad_laba+laba_jalan;

    $("#passiva").val( accounting.formatNumber(passiva, 2) );
  }

  function setNavAt(){
    aktivaat = accounting.unformat($("#aktivaat").val());
    hutang = accounting.unformat($("#assetat-hutang").val());
    hut_lain = accounting.unformat($("#assetat-hut_lain").val());
    unitat = accounting.unformat($("#assetat-unitat").val());

    navat = 0;
    if(unitat>0) navat = ((aktivaat - hutang - hut_lain) / unitat);

    $("#navat").val( accounting.formatNumber(navat, 2) );
    $("#assetat-navat").val( navat );
  }

  function setNav(){
    aktiva = accounting.unformat($("#aktiva").val());
    hutang = accounting.unformat($("#asset-hutang").val());
    hut_lancar = accounting.unformat($("#asset-hut_lancar").val());
    unit = accounting.unformat($("#asset-unit").val());

    nav = 0;
    if(unit>0) nav = ((aktiva - hutang - hut_lancar) / unit );

    $("#nav").val( accounting.formatNumber(nav, 2) );
    $("#asset-nav").val( nav );
  }

  //NAV – NAV.AT)  / NAV.AT * 100
  function setTumbuh(){
    nav = accounting.unformat($("#nav").val());
    navat = accounting.unformat($("#navat").val());

    tumbuh = 0;
    if(navat>0) tumbuh = ((nav - navat) / navat) * 100;

    $("#tumbuh").val( accounting.formatNumber(tumbuh, 2) );
    $("#asset-tumbuh").val( tumbuh );
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
