<?php

namespace App\Services\Task;

use App\DTO\Task\TaskDTO;
use App\Models\Task;
use App\Services\BaseService;
use yii\data\ActiveDataProvider;

class ListTasksForProjectService extends BaseService
{
    const METHOD_NAME = 'listTasks';

    public ?int $project_id = null;
    public ?string $status = null;
    public bool $only_mine = false;

    public function rules(): array
    {
        return [
            [['project_id'], 'required'],
            [['only_mine'], 'boolean'],
            [['status'], 'in', 'range' => Task::$availableStatuses],
        ];
    }

    public function listTasks()
    {
        if ( !$this->validate() ) {
            return false;
        }

        $query = Task::find()
            ->where([
                'deleted_at' => null,
                'project_id' => $this->project_id,
            ])
            ->andFilterWhere(['status' => $this->status]);

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $result = [];

        foreach ($provider->getModels() as $task) {
            $result[] = TaskDTO::makeFromTask($task);
        }

        return $result;
    }
}
