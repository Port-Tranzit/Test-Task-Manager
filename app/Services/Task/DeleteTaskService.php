<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Repositories\ProjectRepository;
use App\Services\BaseService;

class DeleteTaskService extends BaseService
{
    const METHOD_NAME = 'deleteTask';

    public ?int $id = null;

    public function rules(): array
    {
        return [
            [['id'], 'required'],
        ];
    }

    public function deleteTask(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $task = Task::findOne([
            'id' => $this->id,
            'deleted_at' => null,
        ]);

        if (empty($task)) {
            $this->addError('id', 'Задача не найдена');
            return false;
        }

        // Запрет удаления задачи, если пользователь не является участником проекта или создателем задачи
        $currentUserId = $this->getCurrentUserId();
        if ($task->user_created_id !== $currentUserId || !ProjectRepository::userIsProjectOwner($task->project_id, $currentUserId)) {
            $this->addError('id', 'Вы не можете удалить эту задачу');
            return false;
        }

        $task->deleted_at = date(DATETIME_FORMAT);

        if (!$task->save()) {
            $this->addErrors($task->errors);
            return false;
        }

        return true;
    }
}
