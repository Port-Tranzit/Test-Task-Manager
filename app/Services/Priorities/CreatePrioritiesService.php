<?php

namespace App\Services\Priorities;

use App\DTO\Priority\PriorityDTO;
use App\Models\Priority;
use App\Services\BaseService;

class CreatePrioritiesService extends BaseService
{
    const METHOD_NAME = 'create';

    public string $name = '';

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * Создание нового приоритета
     *
     * @return PriorityDTO|bool
     */
    public function create(): PriorityDTO|bool
    {
        if (!$this->validate()) {
            return false;
        }

        $priority = new Priority();
        $priority->name = $this->name;

        if (!$priority->save()) {
            $this->addErrors($priority->errors);
            return false;
        }

        return PriorityDTO::makeFromPriority($priority);
    }
}
