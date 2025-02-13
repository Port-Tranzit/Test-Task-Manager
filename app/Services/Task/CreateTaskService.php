<?php

namespace App\Services\Task;

use App\DTO\Task\TaskDTO;
use App\Models\Task;
use App\Repositories\ProjectRepository;
use App\Services\BaseService;

class CreateTaskService extends BaseService
{
    const METHOD_NAME = 'createTask';

    public ?int $project_id = null;
    public ?int $user_assigned_id = null;
    public ?int $priority_id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $due_until = null;

    public function rules(): array
    {
        return [
            [['project_id', 'priority_id', 'title'], 'required'],
            [['user_assigned_id', 'priority_id'], 'integer'],
            [['description', 'due_until'], 'string'],
        ];
    }

    public function createTask(): TaskDTO|bool
    {
        if (!$this->validate()) {
            return false;
        }

        $project = ProjectRepository::findProjectById($this->project_id);

        if (empty($project)) {
            $this->addError('project_id', 'Проект не найден');
            return false;
        }

        // Запрет добавления задачи, если пользователь не является участником проекта
        if (!ProjectRepository::userIsInProject($project->id, $this->getCurrentUserId())) {
            $this->addError('project_id', 'Вы не являетесь участником проекта');
            return false;
        }

        $task = new Task();
        $task->project_id = $project->id;
        $task->user_created_id = $this->getCurrentUserId();
        $task->user_assigned_id = $this->user_assigned_id;
        $task->priority_id = $this->priority_id;
        $task->status = Task::STATUS_PENDING;
        $task->title = $this->title;
        $task->description = $this->description;

        if (!empty($this->due_until)) {
            $timestamp = strtotime($this->due_until);

            if (!$timestamp) {
                $this->addError('due_until', 'Неверный формат даты');
                return false;
            }

            $task->due_until = date(DATETIME_FORMAT, strtotime($this->due_until));
        }

        if (!$task->save()) {
            $this->addErrors($task->errors);
            return false;
        }

        return TaskDTO::makeFromTask($task);
    }
}
