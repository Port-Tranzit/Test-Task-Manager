<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Services\BaseService;

class DeleteProjectService extends BaseService
{
    const METHOD_NAME = 'deleteProject';

    public ?int $id = null;

    public function rules(): array
    {
        return [
            [['id'], 'required'],
        ];
    }

    public function deleteProject(): bool
    {
        if ( !$this->validate() ) {
            return false;
        }

        $project = ProjectRepository::findProjectById($this->id);

        if ( empty($project) ) {
            $this->addError('id', 'Проект не найден');
            return false;
        }

        if ( $this->getCurrentUserId() !== $project->user_created_id ) {
            $this->addError('id', 'Только создатель проекта может его удалить');
            return false;
        }

        $project->deleted_at = date(DATETIME_FORMAT);

        if ( !$project->save() ) {
            $this->addErrors($project->errors);
            return false;
        }

        return true;
    }
}
