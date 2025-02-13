<?php

namespace api\controllers;

use App\Services\Priorities\CreatePrioritiesService;
use App\Services\Priorities\DeletePrioritiesService;
use App\Services\Priorities\ListPrioritiesService;
use App\Services\Priorities\UpdatePrioritiesService;
use Brezgalov\ApiHelpers\v2\ApiGetAction;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use yii\filters\AccessControl;

class PrioritiesController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge_recursive(parent::behaviors(), [
            'access_control' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => [
                            'list',
                            'create',
                            'update',
                            'delete',
                        ],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'actions' => ['options'],
                    ],
                ],
            ],
        ]);
    }

    public function actions(): array
    {
        return array_merge(parent::actions(), [
            'list' => [
                'class' => ApiGetAction::class,
                'service' => ListPrioritiesService::class,
                'methodName' => ListPrioritiesService::METHOD_NAME,
            ],
            'create' => [
                'class' => ApiPostAction::class,
                'service' => CreatePrioritiesService::class,
                'methodName' => CreatePrioritiesService::METHOD_NAME,
            ],
            'update' => [
                'class' => ApiPostAction::class,
                'service' => UpdatePrioritiesService::class,
                'methodName' => UpdatePrioritiesService::METHOD_NAME,
            ],
            'delete' => [
                'class' => ApiPostAction::class,
                'service' => DeletePrioritiesService::class,
                'methodName' => DeletePrioritiesService::METHOD_NAME,
            ],
        ]);
    }
}
