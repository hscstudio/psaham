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

    </p>

</div>
