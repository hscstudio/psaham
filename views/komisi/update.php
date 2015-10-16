<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Komisi */

$this->title = 'Data Komisi';
$this->params['breadcrumbs'][] = ['label' => 'Komisi', 'url' => ['index']];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="komisi-update">
    <h1 class="ui header"><?= Html::encode($this->title) ?></h1>

    <div class="ui attached message">
      <div class="header">
        Keterangan:
      </div>
      <p>Update data komisi dan jumlah saham perlot</p>
    </div>
    <div class="ui divider"></div>
    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
