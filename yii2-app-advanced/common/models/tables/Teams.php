<?php

namespace common\models\tables;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 *
 * @property TaskProject[] $taskProjects
 * @property TeamProject[] $teamProjects
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskProjects()
    {
        return $this->hasMany(TaskProject::className(), ['id_team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamProjects()
    {
        return $this->hasMany(TeamProject::className(), ['id_team' => 'id']);
    }

    public static function getTeamList()
    {
        $users = static::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        return ArrayHelper::map($users, 'id', 'name');
    }
}
