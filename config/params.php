<?php
use kartik\widgets\AlertBlock;
use kartik\widgets\Growl;
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'alertBlockConfig' => [
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
                'z_index' => 1500,
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'center',
                ],
                //
            ],
          ],
          'error' => [
            'type' => Growl::TYPE_DANGER,
            'title' => 'Perhatian!',
            'icon' => 'glyphicon glyphicon-remove-sign',
            'showSeparator' => true,
            'delay' => 0,
            'pluginOptions' => [
                'z_index' => 1500,
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
                'z_index' => 1500,
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
                'z_index' => 1500,
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'center',
                ]
            ],
          ],
        ],
    ],
];
