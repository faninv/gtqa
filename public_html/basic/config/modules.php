<?php
return [
    'qa' => [
        'class' => 'artkost\qa\Module',
        'userNameFormatter' => function($model) {
            return $model->username ? $model->username : $model->id;
        },
        'controllerMap' => [
            'default' => 'app\modules\qa\controllers\DefaultController'
        ],
    ],
];