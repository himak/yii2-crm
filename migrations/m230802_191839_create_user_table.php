<?php

use app\enums\Role;
use app\enums\Status;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230802_191839_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'status' => $this->boolean()->notNull()->defaultValue(Status::ACTIVE->value),
            'role' => $this->string()->notNull()->defaultValue(Role::USER->value),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'authKey' => $this->string(),
            'accessToken' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
