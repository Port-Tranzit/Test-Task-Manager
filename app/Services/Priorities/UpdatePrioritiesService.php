<?php

namespace App\Services\Priorities;

use App\Models\Priority;
use App\Services\BaseService;

class UpdatePrioritiesService extends BaseService
{
    const METHOD_NAME = 'update';

    public int $id;
    public string $name;

    public function rules(): array
    {
        return [
            [['id', 'name'], 'required'],
        ];
    }

    /**
     * Обновление существующего приоритета
     *
     * @return PriorityDTO|bool
     */
    public function update(): bool
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

        $priority->name = $this->name;

        if (!$priority->save()) {
            $this->addErrors($priority->errors);
            return false;
        }

        return true;
    }
}
