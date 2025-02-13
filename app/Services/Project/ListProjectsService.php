<?php

namespace App\Services\Project;

use App\Models\Project;
use App\DTO\Project\ProjectDTO;
use Yii;

class ListProjectsService
{
    const METHOD_NAME = 'index';

    /**
     * Возвращает список всех проектов
     *
     * @return array
     */
    public function index(): array
    {
        $projects = Project::find()
            ->innerJoin('projects_users pu', 'pu.project_id = projects.id')
            ->where(['pu.user_id' => Yii::$app->user->id])
            ->all();

        return array_map(fn($project) => ProjectDTO::makeFromProject($project), $projects);
    }
}
