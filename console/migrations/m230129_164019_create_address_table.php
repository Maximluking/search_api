<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m230129_164019_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'oblast' => $this->string()->null(),
            'region' => $this->string()->null(),
            'city' => $this->string()->null(),
            'city_region' => $this->string()->null(),
            'street' => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
