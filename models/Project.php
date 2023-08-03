<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int $user_id
 * @property int $account_id
 * @property int $status
 * @property string $name
 * @property int $budget
 *
 * @property Account $account
 * @property Invoice[] $invoices
 * @property User $user
 */
class Project extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'account_id', 'name', 'budget'], 'required'],
            [['user_id', 'account_id', 'status', 'budget'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'account_id' => 'Account ID',
            'status' => 'Status',
            'name' => 'Name',
            'budget' => 'Budget',
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return ActiveQuery|AccountQuery
     */
    public function getAccount(): ActiveQuery|AccountQuery
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return ActiveQuery|InvoiceQuery
     */
    public function getInvoices(): ActiveQuery|InvoiceQuery
    {
        return $this->hasMany(Invoice::class, ['project_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getUser(): UserQuery|ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
