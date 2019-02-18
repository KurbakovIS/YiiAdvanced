<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_project}}`.
 */
class m190216_164026_create_task_project_table extends Migration
{
    protected $tableName = 'task_project';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'id_task' => $this->integer(),
            'name_project' => $this->string(),
            'author_user' => $this->integer(),
            'description' => $this->text()
        ]);
        $taskTable = 'tasks';
        $userTable = 'users';

        $this->addColumn($taskTable, 'id_project', $this->integer());
        $this->addColumn($userTable, 'access_token', $this->string());

        $this->addForeignKey('fk_task_project', $this->tableName, 'id', $taskTable,
            'id_project');
        $this->addForeignKey('fk_procject_user', $this->tableName, 'author_user', $userTable,
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_project}}');
    }
}
