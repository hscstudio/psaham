<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Securitas */

$this->title = 'Create Securitas';
$this->params['breadcrumbs'][] = ['label' => 'Securitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="securitas-create">

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
    ]) ?>

</div>
