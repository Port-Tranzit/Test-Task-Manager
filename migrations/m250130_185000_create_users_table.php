<?php

use yii\db\Migration;

class m250130_185000_create_users_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex('users_IDX_login', 'users', 'login', true);
    }

    public function safeDown(): void
    {
        $this->dropIndex('users_IDX-login', 'users');
        $this->dropTable('users');
    }
}
