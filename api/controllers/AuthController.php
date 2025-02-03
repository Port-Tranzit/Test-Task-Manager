<?php

namespace api\controllers;

use App\Services\User\CreateUserService;
use App\Services\User\GetTokenService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use yii\rest\Controller;

class AuthController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge_recursive(parent::behaviors(), [
            self::BEHAVIOR_AUTHENTICATOR => [
                'except' => [
                    'options',
                    'register',
                    'get-token',
                ],
            ],
        ]);
    }

    public function actions(): array
    {
        return array_merge(parent::actions(), [
            'register' => [
                'class' => ApiPostAction::class,
                'service' => CreateUserService::class,
                'methodName' => CreateUserService::METHOD_NAME,
            ],
            'get-token' => [
                'class' => ApiPostAction::class,
                'service' => GetTokenService::class,
                'methodName' => GetTokenService::METHOD_NAME,
            ],
        ]);
    }
}
