<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [ 
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/music', 'pluralize' => false,
                    'extraPatterns' => [
                        'GET musicswithproducer' => 'musicswithproducer',
                        'GET {id}/title' => 'title', // 'xxxx' é 'actionXxxx'
                        'GET {id}/launchdate' => 'launchdate', // 'xxxx' é 'actionXxxx'
                        'GET {id}/lyrics' => 'lyrics', // 'xxxx' é 'actionXxxx'
                        'GET {id}/pvp' => 'pvp', // 'xxxx' é 'actionXxxx'
                        'GET {id}/musicpath' => 'musicpath', // 'xxxx' é 'actionXxxx'
                        'GET {id}/genre' => 'genre', // 'xxxx' é 'actionXxxx'
                        'GET {id}/producer' => 'producer', // 'xxxx' é 'actionXxxx'
                        'GET count' => 'count',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>', //O standard tem que aparecer!
                        '{limit}' => '<limit:\\d+>',
                        '{from}' => '<from:\\d+>',
                        '{txcode}' => '<txcode:\\w+>',
                        '{kgs}' => '<kgs:(\\d+,\\d+)>'
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'produto', 'pluralize' => false,
                ],
            ],

        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'common\modules\v1\Module',
        ],
    ],
];
