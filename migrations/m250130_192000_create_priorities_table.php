<?php

use yii\db\Migration;

class m250130_192000_create_priorities_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('priorities', [
            'id' => $this->primaryKey(3),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable('priorities');
    }
}
