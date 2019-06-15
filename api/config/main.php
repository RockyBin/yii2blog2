<?php
use yii\web\Request;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'class' => 'yii\web\JsonParser'
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'success' => $response->isSuccessful,
                    'code' => $response->getStatusCode(),
                    'data' => $response->data,
                    'msg' => $response->statusText
                ];

                $response->format = yii\web\Response::FORMAT_JSON;
                $response->statusCode = 200;
            },
        ],
        'user' => [
            'identityClass' => 'common\models\Apiuser',
            'enableAutoLogin' => true,
            'enableSession' => false,
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
            //'class' => 'common\lib\Exception'
        ],
        /**/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing'=>true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST register' => 'register',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'goods',
                    'pluralize' => false,
                    'extraPatterns' => [
                        //'POST,OPTIONS index' => 'index',
                        'GET,OPTIONS index' => 'index'
                    ]
                ],
            ],
        ],

    ],
    'params' => $params,
];
