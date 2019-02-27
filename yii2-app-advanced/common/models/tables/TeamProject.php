<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "team_project".
 *
 * @property int $id
 * @property int $id_team
 * @property int $id_user
 * @property string $role
 *
 * @property Teams $team
 * @property Users $user
 */
class TeamProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_team', 'id_user'], 'integer'],
            [['role'], 'string', 'max' => 255],
            [['id_team'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['id_team' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_team' => 'Id Team',
            'id_user' => 'Id User',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'id_team']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }
}
