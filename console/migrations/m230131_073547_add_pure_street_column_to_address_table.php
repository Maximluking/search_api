<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%address}}`.
 */
class m230131_073547_add_pure_street_column_to_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%address}}', 'pure_street', $this->string()->after('street'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%address}}', 'pure_street');
    }
}
