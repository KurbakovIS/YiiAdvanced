<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teams}}`.
 */
class m190227_222947_create_teams_table extends Migration
{
    protected $tableName = 'teams';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $projectTable = 'task_project';

        $this->addColumn($projectTable, 'id_team', $this->integer());

        $this->addForeignKey('fk_team_projects',$projectTable , 'id_team', $this->tableName,
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%teams}}');
    }
}
