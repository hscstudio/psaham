<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pembelian */

$this->title = 'Create Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-create">

    <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
    <div class="ui attached message">
      <div class="header">
        Keterangan:
      </div>
      <p>Lorem ipsum sit dolor amet </p>
    </div>
    <div class="ui divider"></div>

    <?= $this->render('_form', [
        'model' => $model,
        'lotshare' => $lotshare,
    ]) ?>

</div>
