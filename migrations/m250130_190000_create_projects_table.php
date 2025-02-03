<?php

use yii\db\Migration;

class m250130_190000_create_projects_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('projects', [
            'id' => $this->primaryKey(),
            'user_created_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->createIndex('projects_IDX_user_created_id', 'projects', 'user_created_id');
    }

    public function safeDown(): void
    {
        $this->dropIndex('projects_IDX_user_created_id', 'projects');
        $this->dropTable('projects');
    }
}
