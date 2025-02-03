<?php

namespace App\DTO\Task;

use App\DTO\User\UserDTO;
use App\Models\Task;
use yii\base\Model;

class TaskDTO extends Model
{
    public int $id;
    public int $userCreatedId;
    public ?int $userAssignedId = null;
    public string $status;
    public string $title;
    public ?string $description = null;
    public ?string $dueUntil = null;
    public string $createdAt;
    public string $updatedAt;

    public UserDTO $author;
    public ?UserDTO $assignee;

    public static function makeFromTask(Task $task): self
    {
        $instance = new self();
        $instance->id = $task->id;
        $instance->userCreatedId = $task->user_created_id;
        $instance->userAssignedId = $task->user_assigned_id;
        $instance->status = $task->status;
        $instance->title = $task->title;
        $instance->description = $task->description;
        $instance->dueUntil = $task->due_until;
        $instance->createdAt = $task->created_at;
        $instance->updatedAt = $task->updated_at;

        $instance->author = UserDTO::makeFromUser($task->userCreated);

        if ( !empty($task->userAssigned) ) {
            $instance->assignee = UserDTO::makeFromUser($task->userAssigned);
        }

        return $instance;
    }
}
