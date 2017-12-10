<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Блог на Yii2',
    'basePath' => dirname(__DIR__),
    'sourceLanguage' => 'en',
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'layout' => 'blog',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'modules' => [
        'adminblog' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '\main',
        ],
        'admin' => [
            //'class' => 'app\modules\admin\Module',
            'class' => 'mdm\admin\Module',
            //'layout' => 'top-menu',
            'layout' => '@app/modules/admin/views/layouts/main',

            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'user_id',
                    'usernameField' => 'username',
                ],
            ],
            'menus' => [
//                'assignment' => [
//                    'label' => 'Grand Access' // change label
//                ],
                [
                    'label' => 'Управнение блогом',
                    'items' => [
                        [
                            'label' => 'Управление постами',
                            'url' => ['/adminblog/post/index'],
                        ],
                        [
                            'label' => 'Управление комментариями',
                            'url' => ['/adminblog/comment/index'],
                        ],
                        [
                            'label' => 'Управление тегами',
                            'url' => ['/adminblog/tag/index'],
                        ],
                    ],
                ],
            ],

            //Управление доступом
            'as access' => [
                'class' => 'mdm\admin\components\AccessControl',
                'allowActions' => [
                    //'site/*',
                    'user/logout',
                    'user/signup',
                    //'some-controller/some-action',
                ]
            ],
        ],
    ],

    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lNrcgDeiL2rB245lxL1f4I78ZXz81ebW',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
