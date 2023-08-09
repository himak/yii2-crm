<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $status
 * @property string $role
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $accessToken
 *
 * @property Account[] $accounts
 * @property Invoice[] $invoices
 * @property Project[] $projects
 */
class User extends ActiveRecord implements IdentityInterface
{
    private static array $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;

//        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['status', 'role', 'username', 'password'], 'required'],
            [['role', 'username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'role' => 'Role',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * Gets query for [[Accounts]].
     *
     * @return ActiveQuery|AccountQuery
     */
    public function getAccounts(): ActiveQuery|AccountQuery
    {
        return $this->hasMany(Account::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return ActiveQuery|InvoiceQuery
     */
    public function getInvoices(): ActiveQuery|InvoiceQuery
    {
        return $this->hasMany(Invoice::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return ActiveQuery|ProjectQuery
     */
    public function getProjects(): ActiveQuery|ProjectQuery
    {
        return $this->hasMany(Project::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }
}
