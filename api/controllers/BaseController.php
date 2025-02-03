<?php

namespace api\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\rest\OptionsAction;
use yii\web\Response;

abstract class BaseController extends Controller
{
    const BEHAVIOR_CONTENT_NEGOTIATOR = 'contentNegotiator';
    const BEHAVIOR_AUTHENTICATOR = 'authenticator';

    const ACTION_OPTIONS = 'options';

    public function behaviors(): array
    {
        return [
            self::BEHAVIOR_CONTENT_NEGOTIATOR => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                    'application/pdf' => Response::FORMAT_RAW,
                ],
            ],
            self::BEHAVIOR_AUTHENTICATOR => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                    [
                        'class' => QueryParamAuth::class,
                        'tokenParam' => 'a-token',
                    ]
                ],
                'except' => ['options'],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            self::ACTION_OPTIONS => OptionsAction::class,
        ];
    }
}
