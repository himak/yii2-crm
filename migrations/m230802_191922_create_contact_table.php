<?php

use app\enums\Status;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m230802_191922_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(Status::DEACTIVATED->value),
            'name' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
        ]);

        // add foreign key for table `account`
        $this->addForeignKey(
            'fk-contact-account_id',
            'contact',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-contact-account_id',
            'contact'
        );

        $this->dropTable('{{%contact}}');
    }
}
