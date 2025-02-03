<?php

namespace App\DTO\Project;

use App\DTO\User\UserDTO;
use App\Models\Project;
use yii\base\Model;

class ProjectDTO extends Model
{
    public int $id;
    public string $title;
    public ?string $description;
    public string $createdAt;
    public string $updatedAt;
    public ?string $deletedAt = null;

    public UserDTO $author;

    public static function makeFromProject(Project $project): self
    {
        $instance = new self();
        $instance->id = $project->id;
        $instance->title = $project->title;
        $instance->description = $project->description;
        $instance->createdAt = $project->created_at;
        $instance->updatedAt = $project->updated_at;
        $instance->deletedAt = $project->deleted_at;

        $instance->author = UserDTO::makeFromUser($project->userCreated);

        return $instance;
    }

    public function fields(): array
    {
        return [
            'id',
            'title',
            'description',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
            'deleted_at' => 'deletedAt',
            'author',
        ];
    }
}
