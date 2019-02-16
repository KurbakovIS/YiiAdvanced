<?php

namespace common\models\tables;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "task_project".
 *
 * @property int $id
 * @property string $name_project
 * @property int $author_user
 * @property string $description
 *
 * @property Users $authorUser
 * @property Tasks[] $tasks
 */
class TaskProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_user'], 'integer'],
            [['description'], 'string'],
            [['name_project'], 'string', 'max' => 255],
            [['name_author'], 'string', 'max' => 255],
            [['author_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_project' => 'Name Project',
            'author_user' => 'Author User',
            'description' => 'Description',
            'name_author' => 'Name Author',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'author_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public  function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['id_project' => 'id']);
    }

    public static function getProjectList()
    {
        $projects = static::find()
            ->select(['id', 'name_project'])
            ->asArray()
            ->all();

        return ArrayHelper::map($projects, 'id', 'name_project');
    }
}
