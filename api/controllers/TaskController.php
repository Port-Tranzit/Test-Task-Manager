<?php

namespace api\controllers;

use App\Services\Task\ChangeTaskStatusService;
use App\Services\Task\CreateTaskService;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\ListTasksForProjectService;
use Brezgalov\ApiHelpers\v2\ApiGetAction;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use yii\filters\AccessControl;

class TaskController extends BaseController
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
                            'delete',
                            'change-status',
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
                'service' => ListTasksForProjectService::class,
                'methodName' => ListTasksForProjectService::METHOD_NAME,
            ],

            'create' => [
                'class' => ApiPostAction::class,
                'service' => CreateTaskService::class,
                'methodName' => CreateTaskService::METHOD_NAME,
            ],
            'delete' => [
                'class' => ApiPostAction::class,
                'service' => DeleteTaskService::class,
                'methodName' => DeleteTaskService::METHOD_NAME,
            ],
            'change-status' => [
                'class' => ApiPostAction::class,
                'service' => ChangeTaskStatusService::class,
                'methodName' => ChangeTaskStatusService::METHOD_NAME,
            ],
        ]);
    }
}
