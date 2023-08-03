<?php

use app\enums\Status;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m230802_191931_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(Status::DEACTIVATED->value),
            'name' => $this->string()->notNull(),
            'budget' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-project-user_id',
            'project',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `account`
        $this->addForeignKey(
            'fk-project-account_id',
            'project',
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
            'fk-project-user_id',
            'project'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-project-account_id',
            'project'
        );

        $this->dropTable('{{%project}}');
    }
}
