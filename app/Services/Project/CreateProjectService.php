<?php

namespace App\Services\Project;

use App\DTO\Project\ProjectDTO;
use App\Models\Project;
use App\Services\BaseService;
use App\Services\ProjectUser\AddUserService;
use Yii;

class CreateProjectService extends BaseService
{
    const METHOD_NAME = 'createProject';

    public ?string $title = null;
    public ?string $description = null;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
        ];
    }

    public function createProject(): bool|ProjectDTO
    {
        if ( !$this->validate() ) {
            return false;
        }

        $project = new Project();
        $project->user_created_id = $this->getCurrentUserId();
        $project->title = $this->title;
        $project->description = $this->description;

        if ( !$project->save() ) {
            $this->addErrors($project->errors);
            return false;
        }

        $service = Yii::createObject(AddUserService::class);
        $service->registerInput([
            'project_id' => $project->id,
            'user_id' => $this->getCurrentUserId(),
        ]);

        if ( !$service->addUser() ) {
            $this->addErrors($service->errors);
            return false;
        }

        return ProjectDTO::makeFromProject($project);
    }
}
