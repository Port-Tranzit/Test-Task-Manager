<?php

use yii\db\Migration;

class m250130_193000_add_priorities_to_tasks_table extends Migration
{
    public function safeUp(): void
    {
        $this->addColumn('tasks', 'priority_id', $this->integer());

        $this->addForeignKey(
            'fk_tasks_priority',
            'tasks',
            'priority_id',
            'priorities',
            'id'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk_tasks_priority', 'tasks');
        $this->dropColumn('tasks', 'priority_id');
    }
}
