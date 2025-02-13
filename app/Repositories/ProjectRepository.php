<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectUser;

final class ProjectRepository
{
    public static function findProjectById(int $projectId): ?Project
    {
        return Project::findOne([
            'id' => $projectId,
            'deleted_at' => null,
        ]);
    }

    /**
     * Проверяет, является ли пользователь участником проекта
     *
     * @param int $projectId
     * @param int $userId
     * @return bool
     */
    public static function userIsInProject(int $projectId, int $userId): bool
    {
        return ProjectUser::find()
            ->where(['project_id' => $projectId, 'user_id' => $userId])
            ->exists();
    }

    /**
     * Проверяет, является ли пользователь создателем проекта
     *
     * @param int $projectId
     * @param int $userId
     * @return bool
     */
    public static function userIsProjectOwner(int $projectId, int $userId): bool
    {
        return Project::find()
            ->where(['id' => $projectId, 'user_created_id' => $userId])
            ->exists();
    }
}
