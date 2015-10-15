<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use Zelenin\yii\SemanticUI\collections\Breadcrumb;
use app\assets\AppAsset;
//use app\widgets\Alert;
use kartik\widgets\AlertBlock;
use kartik\widgets\Growl;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
        'innerContainerOptions' => [
            'class' => 'container-fluid'
        ]
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        //['label' => 'About', 'url' => ['/site/about']],
        //['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'App', 'items' => [
            ['label' => 'Komisi', 'url' => ['/komisi/index']],
            ['label' => 'Securitas', 'url' => ['/securitas/index']],
            ['label' => 'Emiten', 'url' => ['/emiten/index']],
            ['label' => 'Pembelian', 'url' => ['/pembelian/index']],
        ]];
        /*
        $menuItems[] = ['label' => 'Admin', 'items' => [
              ['label' => 'Assigment', 'url' => ['/admin/assignment']],
              ['label' => 'Role', 'url' => ['/admin/role']],
              ['label' => 'Permision', 'url' => ['/admin/permission']],
              ['label' => 'Menu', 'url' => ['/admin/menu']],
          ]];
        */
        $menuItems[] = ['label' => substr(Yii::$app->user->identity->username,0,10), 'items' => [
              ['label' => 'Profile', 'url' => ['/site/profile']],
              [
                  'label' => 'Logout',
                  'url' => ['/site/logout'],
                  'linkOptions' => ['data-method' => 'post']
              ],
          ]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="ui container-fluid">
      <div style="margin:65px 0 10px 0;">
        <div style="">
          <?= Breadcrumb::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
        </div>
        <div class="ui blue piled segment">
        <?= AlertBlock::widget([
            'type' => AlertBlock::TYPE_GROWL,
            'useSessionFlash' => true,
            'alertSettings' => [
              'success' => [
                'type' => Growl::TYPE_SUCCESS,
                'title' => 'Informasi!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ],
              ],
              'error' => [
                'type' => Growl::TYPE_DANGER,
                'title' => 'Perhatian!',
                'icon' => 'glyphicon glyphicon-remove-sign',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ],
              ],
              'info' => [
                'type' => Growl::TYPE_INFO,
                'title' => 'Informasi!',
                'icon' => 'glyphicon glyphicon-info-sign',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ],
              ],
              'warning' => [
                'type' => Growl::TYPE_WARNING,
                'title' => 'Perhatian!',
                'icon' => 'glyphicon glyphicon-exclamation-sign',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ],
              ],
            ],
        ]); ?>
        <?= $content ?>
        </div>
      </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
