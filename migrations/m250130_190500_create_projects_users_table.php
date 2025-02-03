<?php

use yii\db\Migration;

class m250130_190500_create_projects_users_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('projects_users', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'projects_users_IDX_project_user',
            'projects_users',
            ['project_id', 'user_id'],
            true
        );

        $this->addForeignKey(
            'projects_users_FK_project_id',
            'projects_users',
            'project_id',
            'projects',
            'id'
        );
        $this->addForeignKey(
            'projects_users_FK_user_id',
            'projects_users',
            'user_id',
            'users',
            'id'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('projects_users_FK_user_id', 'projects_users');
        $this->dropForeignKey('projects_users_FK_project_id', 'projects_users');

        $this->dropIndex('projects_users_IDX_project_user', 'projects_users');

        $this->dropTable('projects_users');
    }
}
