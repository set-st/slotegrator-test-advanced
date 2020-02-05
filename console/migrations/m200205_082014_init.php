<?php

use yii\db\Migration;

/**
 * Class m200205_082014_init
 */
class m200205_082014_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wins}}', [
            'id' => $this->primaryKey(),
            'uId' => $this->integer(12)->notNull(),
            'type' => $this->integer(2)->null()->defaultValue(1),
            'amount' => $this->double()->null()->defaultValue(0),
            'description' => $this->string(512)->null(),
            'createdAt' => $this->dateTime()->null(),
            'sendAt' => $this->dateTime()->null(),
        ]);

        $this->createIndex('type', '{{%wins}}', 'type');
        $this->createIndex('createdAt', '{{%wins}}', 'createdAt');
        $this->createIndex('sendAt', '{{%wins}}', 'sendAt');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wins}}');
    }
}
