<?php

use app\enums\Status;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m230802_191900_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(Status::DEACTIVATED->value),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-account-user_id',
            'account',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-account-user_id',
            'account'
        );

        $this->dropTable('{{%account}}');
    }
}
