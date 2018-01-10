<?php

use yii\db\Migration;

/**
 * Class m180109_195917_service_table
 */
class m180109_195917_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'description_list' => $this->string(),
            'price' => $this->integer(),
            'status' => $this->integer(),
            'data' => 'json',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('service_user', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->integer(),
            'paid_to' => $this->integer(),
            'data' => 'json',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('service_user_idx', 'service_user', 'user_id');
        $this->createIndex('service_service_idx', 'service_user', 'service_id');


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('service');
        $this->dropTable('service_user');
    }
}
