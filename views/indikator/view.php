<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Indikator */

$this->title = $model->TGL;
$this->params['breadcrumbs'][] = ['label' => 'Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indikator-view">

    <?php if (!Yii::$app->request->isAjax){ ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'TGL',
            'NAMA',
            'NAVAT',
            'NAV',
            'TUMBUH',
        ],
    ]) ?>

    <p>
        <?= Html::a('Cancel',['index'],['class'=>'btn btn-default','onclick'=>(Yii::$app->request->isAjax)?'$("#myModal").modal("hide");return false':'']) ?>
    </p>
</div>
