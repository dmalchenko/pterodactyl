<?php

use yii\db\Migration;

/**
 * Class m171202_143449_user
 */
class m171202_143449_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'service' => $this->string(),
            'service_id' => $this->string(),
            'username' => $this->string(),
            'token' => $this->bigInteger(20),
            'balance' => $this->integer(),
            'data' => 'json',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('user_token_idx', 'user', 'token', true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
