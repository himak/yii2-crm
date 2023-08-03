<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property string $name
 * @property string|null $address
 *
 * @property Contact[] $contacts
 * @property Invoice[] $invoices
 * @property Project[] $projects
 * @property User $user
 */
class Account extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'name' => 'Name',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Contacts]].
     *
     * @return ActiveQuery|ContactQuery
     */
    public function getContacts(): ActiveQuery|ContactQuery
    {
        return $this->hasMany(Contact::class, ['account_id' => 'id']);
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return ActiveQuery|InvoiceQuery
     */
    public function getInvoices(): ActiveQuery|InvoiceQuery
    {
        return $this->hasMany(Invoice::class, ['account_id' => 'id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return ActiveQuery|ProjectQuery
     */
    public function getProjects(): ActiveQuery|ProjectQuery
    {
        return $this->hasMany(Project::class, ['account_id' => 'id']);
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
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }
}
