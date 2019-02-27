<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teamProject}}`.
 */
class m190227_214622_create_teamProject_table extends Migration
{
    protected $tableName = 'team_project';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'id_team'=>$this->integer(),
            'id_user'=>$this->integer(),
            'role'=>$this->string()
        ]);

        $userTable = 'users';
        $teamTable = 'teams';

        $this->addForeignKey('fk_team_teamProject', $this->tableName, 'id_team', $teamTable,
            'id');
        $this->addForeignKey('fk_team_user', $this->tableName, 'id_user', $userTable,
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%teamProject}}');
    }
}
