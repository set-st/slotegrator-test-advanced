<?php

use yii\db\Migration;

/**
 * Class m200205_083442_user_account
 */
class m200205_083442_user_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'money', $this->float()->null()->defaultValue(0));
        $this->addColumn('{{%user}}', 'bonuses', $this->float()->null()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'money');
        $this->dropColumn('{{%user}}', 'bonuses');
    }
}
