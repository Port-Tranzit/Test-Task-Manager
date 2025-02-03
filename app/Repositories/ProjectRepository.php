<?php

namespace App\Repositories;

use App\Models\Project;

final class ProjectRepository
{
    public static function findProjectById(int $projectId): ?Project
    {
        return Project::findOne([
            'id' => $projectId,
            'deleted_at' => null,
        ]);
    }
}
