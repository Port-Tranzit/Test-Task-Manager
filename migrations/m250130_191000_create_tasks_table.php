<?php

use yii\db\Migration;

class m250130_191000_create_tasks_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_created_id' => $this->integer()->notNull(),
            'user_assigned_id' => $this->integer(),
            'status' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'due_until' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'tasks_FK_project_id',
            'tasks',
            'project_id',
            'projects',
            'id'
        );
        $this->addForeignKey(
            'tasks_FK_user_created_id',
            'tasks',
            'user_created_id',
            'users',
            'id'
        );
        $this->addForeignKey(
            'tasks_FK_user_assigned_id',
            'tasks',
            'user_assigned_id',
            'users',
            'id'
        );
    }

    public function safeDown(): void
    {
        $this->dropIndex('tasks_FK_user_assigned_id', 'tasks');
        $this->dropIndex('tasks_FK_user_created_id', 'tasks');
        $this->dropIndex('tasks_FK_project_id', 'tasks');

        $this->dropTable('tasks');
    }
}
