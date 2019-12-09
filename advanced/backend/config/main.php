<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'backend\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [ 
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/music'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET musicswithproducer' => 'musicswithproducer',
                        'GET {id}/titlemusic' => 'title', // 'xxxx' é 'actionXxxx'
                        'GET {id}/launchdatemusic' => 'launchdate', // 'xxxx' é 'actionXxxx'
                        'GET {id}/lyricsmusic' => 'lyrics', // 'xxxx' é 'actionXxxx'
                        'GET {id}/pvpmusic' => 'pvp', // 'xxxx' é 'actionXxxx'
                        'GET {id}/musicpathmusic' => 'musicpath', // 'xxxx' é 'actionXxxx'
                        'GET {id}/genremusic' => 'genre', // 'xxxx' é 'actionXxxx'
                        'GET {id}/producermusic' => 'producer', // 'xxxx' é 'actionXxxx'
                        'GET countmusic' => 'count',
                        'GET {id}/mp3filemusic' => 'mp3file',
                        'GET search/{txcode}' => 'search',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>', //O standard tem que aparecer!
                        '{txcode}' => '<txcode:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/default'], 'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/albums'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/title' => 'titlealbum', // 'xxxx' é 'actionXxxx'
                        'GET {id}/launchdate' => 'launchdatealbum', // 'xxxx' é 'actionXxxx'
                        'GET {id}/genre' => 'genrealbum', // 'xxxx' é 'actionXxxx'
                        'GET {id}/musics' => 'musics', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}' => 'music', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/title' => 'titlemusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/launchdate' => 'launchdatemusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/lyrics' => 'lyricsmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/pvp' => 'pvpmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/musicpath' => 'musicpathmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/genre' => 'genremusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/producer' => 'producermusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/mp3file' => 'mp3filemusic', // 'xxxx' é 'actionXxxx'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>', //O standard tem que aparecer!
                        '{idmusic}' => '<idmusic:\\d+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/playlists'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/nome' => 'nomeplaylist', // 'xxxx' é 'actionXxxx'
                        'GET {id}/creationdate' => 'creationdateplaylist', // 'xxxx' é 'actionXxxx'
                        'GET {id}/genres' => 'genresplaylist', // 'xxxx' é 'actionXxxx'
                        'GET {id}/musics' => 'musicsplaylist', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}' => 'music', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/title' => 'titlemusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/launchdate' => 'launchdatemusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/lyrics' => 'lyricsmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/pvp' => 'pvpmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/musicpath' => 'musicpathmusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/genre' => 'genremusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/producer' => 'producermusic', // 'xxxx' é 'actionXxxx'
                        'GET {id}/music/{idmusic}/mp3file' => 'mp3filemusic', // 'xxxx' é 'actionXxxx'
                        'POST playlistcreate' => 'playlistcreate', // 'xxxx' é 'actionXxxx'
                        'PUT playlistupdate/{id}' => 'playlistupdate', // 'xxxx' é 'actionXxxx'
                        'DELETE delete/{id}' => 'playlistdelete', // 'xxxx' é 'actionXxxx'
                        'POST putsong' => 'playlistputsong', // 'xxxx' é 'actionXxxx'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>', //O standard tem que aparecer!
                        '{idmusic}' => '<idmusic:\\d+>',
                    ],
                ],
            ],

        ],
    ],
    'params' => $params,
];
