<?php

namespace api\controllers;

use api\formatters\ProjectFormatter;
// use App\Models\Project;
use App\Services\Project\CreateProjectService;
use App\Services\Project\DeleteProjectService;
use App\Services\Project\ListProjectsService;
use App\Services\ProjectUser\AddUserService;
use App\Services\ProjectUser\RemoveUserService;
use Brezgalov\ApiHelpers\v2\ApiGetAction;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use yii\filters\AccessControl;
// use yii\rest\IndexAction;

class ProjectController extends BaseController
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
                            'index',
                            'create',
                            'delete',
                            'add-user',
                            'remove-user',
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
            'index' => [
                'class' => ApiGetAction::class,
                'service' => [
                    'class' => ListProjectsService::class,
                ],
                'methodName' => ListProjectsService::METHOD_NAME,
                'formatter' => ProjectFormatter::class,
            ],
            /* 'index' => [
                'class' => ApiGetAction::class,
                'service' => [
                    'class' => IndexAction::class,
                    'modelClass' => Project::class,
                ],
                'methodName' => 'run',
                'formatter' => ProjectFormatter::class,
            ], */
            'create' => [
                'class' => ApiPostAction::class,
                'service' => CreateProjectService::class,
                'methodName' => CreateProjectService::METHOD_NAME,
            ],
            'delete' => [
                'class' => ApiPostAction::class,
                'service' => DeleteProjectService::class,
                'methodName' => DeleteProjectService::METHOD_NAME,
            ],
            'add-user' => [
                'class' => ApiPostAction::class,
                'service' => AddUserService::class,
                'methodName' => AddUserService::METHOD_NAME,
            ],
            'remove-user' => [
                'class' => ApiPostAction::class,
                'service' => RemoveUserService::class,
                'methodName' => RemoveUserService::METHOD_NAME,
            ],
        ]);
    }
}
