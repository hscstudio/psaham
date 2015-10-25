<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Securitas */

$this->title = $model->KODE;
$this->params['breadcrumbs'][] = ['label' => 'Securitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="securitas-view">
  <?php if (!Yii::$app->request->isAjax){ ?>
  <h2 class="ui header"><?= Html::encode($this->title) ?></h2>
  <div class="ui attached message">
    <div class="header">
      Keterangan:
    </div>
    <p>Lorem ipsum sit dolor amet </p>
  </div>
  <div class="ui divider"></div>
  <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'KODE',
            'NAMA',
            'ALAMAT',
            'TELP',
            'CP',
            'HP',
        ],
    ]) ?>

    <p>

        <?= Html::a('Delete', ['delete', 'id' => $model->KODE], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default',
        'onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']); ?>
        
    </p>

</div>
