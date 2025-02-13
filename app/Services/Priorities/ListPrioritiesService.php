<?php

namespace App\Services\Priorities;

use App\DTO\Priority\PriorityDTO;
use App\Models\Priority;
use App\Services\BaseService;

class ListPrioritiesService extends BaseService
{
    const METHOD_NAME = 'index';

    /**
     * Возвращает список всех приоритетов
     *
     * @return array
     */
    public function index(): array
    {
        $projects = Priority::find()->all();
        return array_map(fn($project) => PriorityDTO::makeFromPriority($project), $projects);
    }
}
