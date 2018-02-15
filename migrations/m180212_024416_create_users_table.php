<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180212_024416_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->unique()->notNull(),
            'fullname'=>$this->string(),
            'designation'=>$this->string(),
            'password_hash' => $this->string()->notNull(),
            'authKey'=>$this->string(),
            'role'=>$this->integer()->notNull(),
            'department'=>$this->string(45)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
