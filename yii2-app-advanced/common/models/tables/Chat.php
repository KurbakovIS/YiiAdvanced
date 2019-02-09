<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $message
 * @property int $id_Task
 * @property int $id_User
 * @property string $timeMessage
 *
 * @property Tasks $task
 * @property Users $user
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_Task', 'id_User'], 'integer'],
            [['timeMessage'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['id_Task'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['id_Task' => 'id']],
            [['id_User'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['id_User' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'id_Task' => 'Id Task',
            'id_User' => 'Id User',
            'timeMessage' => 'Time Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'id_Task']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'id_User']);
    }
}
