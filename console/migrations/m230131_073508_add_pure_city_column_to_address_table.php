<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%address}}`.
 */
class m230131_073508_add_pure_city_column_to_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%address}}', 'pure_city', $this->string()->after('city'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%address}}', 'pure_city');
    }
}
