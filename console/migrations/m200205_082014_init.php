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
        $this->createTable('wins', [
            'id' => $this->primaryKey(),
            'uId' => $this->integer(12)->notNull(),
            'type' => $this->integer(2)->null()->defaultValue(1),
            'amount' => $this->double()->null()->defaultValue(0),
            'description' => $this->string(512)->null(),
            'createdAt' => $this->dateTime()->null(),
            'sendAt' => $this->dateTime()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200205_082014_init cannot be reverted.\n";

        return false;
    }
}
