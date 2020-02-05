<?php

use yii\db\Migration;

/**
 * Class m200205_091822_add_indexes
 */
class m200205_091822_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('amount', '{{%wins}}', 'amount');
        $this->createIndex('description', '{{%wins}}', 'description');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200205_091822_add_indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200205_091822_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
