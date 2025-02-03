<?php

use yii\db\Migration;

class m250130_185500_create_tokens_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('tokens', [
            'token' => $this->string()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'expired_at' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addPrimaryKey('tokens_PK', 'tokens', 'token');

        $this->createIndex('tokens_IDX_expired_at', 'tokens', 'expired_at');
    }

    public function safeDown(): void
    {
        $this->dropIndex('tokens_IDX_expired_at', 'tokens');

        $this->dropTable('tokens');
    }
}
