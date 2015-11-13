<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Note */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'created_at',
            'updated_at',
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
