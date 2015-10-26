<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indikator */

$this->title = 'Update Indikator: ' . ' ' . $model->TGL;
$this->params['breadcrumbs'][] = ['label' => 'Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TGL, 'url' => ['view', 'TGL' => $model->TGL, 'NAMA' => $model->NAMA]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="indikator-update">

    <?php if (!Yii::$app->request->isAjax){ ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
