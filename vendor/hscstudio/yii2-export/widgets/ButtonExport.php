<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace hscstudio\export\widgets;

use yii\helpers\Html;
/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', 'This is the message');
 * \Yii::$app->session->setFlash('success', 'This is the message');
 * \Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Hafid Mukhlasin <hafidmukhlasin@gmail.com>
 */
class ButtonExport extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $buttons = [
        'excel',
        'pdf',
    ];

    public function init()
    {
        parent::init();
        echo Html::beginTag('div', ['class'=>'btn-group']);
          echo Html::beginTag('button', [
            'id'=>'w1',
            'class'=>'btn btn-default dropdown-toggle',
            'href'=>'#',
            'title'=>'Export',
            'data-toggle'=>'dropdown',
            'aria-expanded'=>'true',
          ]);
          echo Html::tag('i','',['class'=>'glyphicon glyphicon-export']);
          echo Html::tag('span','',['class'=>'caret']);
          echo Html::endTag('button');
          echo Html::beginTag('ul', ['id'=>'w2','class'=>'dropdown-menu dropdown-menu-right']);
            echo Html::tag('li','Export Page Data',['role'=>'presentation','class'=>'dropdown-header']);
            echo Html::beginTag('li',['title'=>"Microsoft Excel 2007"]);
            echo Html::a('<i class="text-success fa fa-file-excel-o"></i> Excel',['export-excel'],['data-pjax'=>0]);
            echo Html::endTag('li');
            echo Html::beginTag('li',['title'=>"Portable Document Format"]);
            echo Html::a('<i class="text-danger fa fa-file-pdf-o"></i> PDF',['export-pdf'],['data-pjax'=>0]);
            echo Html::endTag('li');
          echo Html::endTag('ul');
        echo Html::endTag('div');
    }
}
