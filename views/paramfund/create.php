<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paramfund */

$this->title = 'Create Paramfund';
$this->params['breadcrumbs'][] = ['label' => 'Paramfunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paramfund-create">

  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Input data parameter </p>
  </div>
  <div class="ui divider"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
