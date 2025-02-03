<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\BaseService;

class ChangeTaskStatusService extends BaseService
{
    const METHOD_NAME = 'changeStatus';

    public ?int $id = null;
    public ?string $status = null;

    public function rules(): array
    {
        return [
            [['id', 'status'], 'required'],
            ['status', 'in', 'range' => Task::$availableStatuses],
        ];
    }

    public function changeStatus(): bool
    {
        if ( !$this->validate() ) {
            return false;
        }

        $task = Task::findOne([
            'id' => $this->id,
            'deleted_at' => null,
        ]);

        if ( empty($task) ) {
            $this->addError('id', 'Задача не найдена');
            return false;
        }

        $task->status = $this->status;

        if ( !$task->save() ) {
            $this->addErrors($task->errors);
            return false;
        }

        return true;
    }
}
