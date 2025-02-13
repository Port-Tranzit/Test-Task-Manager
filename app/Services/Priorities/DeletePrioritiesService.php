<?php

namespace App\Services\Priorities;

use App\Models\Priority;
use App\Models\Task;
use App\Services\BaseService;

class DeletePrioritiesService extends BaseService
{
    const METHOD_NAME = 'delete';

    public int $id;

    public function rules(): array
    {
        return [
            [['id'], 'required'],
        ];
    }

    /**
     * Удаление приоритета
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $priority = Priority::findOne([
            'id' => $this->id,
        ]);

        if (empty($priority)) {
            $this->addError('id', 'Приоритет не найден');
            return false;
        }

        // Првоерка существования приоритета в какой-либо задаче
        if (Task::find()->where(['priority_id' => $this->id])->exists()) {
            $this->addError('id', 'Удаление запрещено, так как он уже используется');
            return false;
        }

        if (!$priority->delete()) {
            $this->addErrors($priority->errors);
            return false;
        }

        return true;
    }
}
