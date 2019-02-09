<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m190209_202334_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    protected $chatTable = 'chat';

    public function safeUp()
    {
        $this->createTable($this->chatTable, [
            'id' => $this->primaryKey(),
            'message'=>$this->string(255),
            'id_Task'=>$this->integer(),
            'id_User'=>$this->integer(),
            'timeMessage'=>$this->dateTime()
        ]);

        $taskTable ='tasks';
        $userTable = 'users';

        $this->addForeignKey('fk_chat_tasks', $this->chatTable, 'id_Task',
            $taskTable, 'id');
        $this->addForeignKey('fk_chat_users', $this->chatTable, 'id_User',
            $userTable, 'id');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->chatTable);
    }
}
