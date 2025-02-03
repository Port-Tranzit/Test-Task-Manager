<?php

namespace App\Services\Task;

use App\Models\Task;
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

        $task->deleted_at = date(DATETIME_FORMAT);

        if ( !$task->save() ) {
            $this->addErrors($task->errors);
            return false;
        }

        return true;
    }
}
