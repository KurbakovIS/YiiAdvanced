<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 *
 * @property Tasks $id0
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_AUTH = 'auth';


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
//                'value' => new Expression('NOW()'),
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }
            ]

        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['name', 'login', 'password'], 'string', 'max' => 222],
            [['login'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class,
                'targetAttribute' => ['id' => 'responsible_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Name',
            'email' => 'Email',
            'role_id' => 'Role_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        return $this->hasOne(Tasks::class, ['responsible_id' => 'id']);
    }


//    public function getRole()
//    {
//        return $this->hasOne(Roles::class, ['id' => 'role_id']);
//    }
    public function getUsername()
    {
        return \Yii::$app->user->identity->getId();
    }

    public function fields()
    {
        if ($this->scenario == self::SCENARIO_AUTH) {
            return [
                'id',
                'username' => 'login',
                'password',
            ];
        }
        return parent::fields();
    }

    public static function getUsersList()
    {
        $users = static::find()
            ->select(['id', 'username'])
            ->asArray()
            ->all();

        return ArrayHelper::map($users, 'id', 'username');
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


}
