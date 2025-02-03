<?php

namespace App\Commands;

use App\Models\Task;
use yii\console\Controller;
use yii\console\ExitCode;

class TaskController extends Controller
{
    public function actionUpdate(): int
    {
        /** @var Task[] $expiredTasks */
        $expiredTasks = Task::find()
            ->where([
                'and',
                ['deleted_at' => null],
                ['<', 'due_until', date(DATETIME_FORMAT)],
            ])
            ->all();

        $count = count($expiredTasks);

        echo "Found {$count} expired tasks..." . PHP_EOL;

        foreach ($expiredTasks as $task) {
            $task->deleted_at = date(DATETIME_FORMAT);

            if ( !$task->save() ) {
                echo json_encode($task->getFirstErrors()) . PHP_EOL;
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }

        return ExitCode::OK;
    }
}
