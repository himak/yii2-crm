<?php

use app\enums\Status;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice}}`.
 */
class m230802_191938_create_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(Status::DEACTIVATED->value),
            'number' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-invoice-user_id',
            'invoice',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `project`
        $this->addForeignKey(
            'fk-invoice-project_id',
            'invoice',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );

        // add foreign key for table `account`
        $this->addForeignKey(
            'fk-invoice-account_id',
            'invoice',
            'account_id',
            'account',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice}}');
    }
}
