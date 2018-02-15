<?php

use yii\db\Migration;

/**
 * Handles the creation of table `requests`.
 */
class m180212_040653_create_requests_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('requests', [
            'id' => $this->primaryKey(),
            'date'=>$this->date()->notNull(),
            'requested_by' => $this->integer(),
            'approved_by' => $this->integer(),
            'status' => $this->smallInteger(1)
        ]);

        $this->createIndex(
            'idx_requests_requested_by',
            'requests',
            'requested_by'
        );

        $this->addForeignKey(
            'fk_requests_requested',
            'requests',
            'requested_by',
            'users',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx_requests_approved_by',
            'requests',
            'approved_by'
        );

        $this->addForeignKey(
            'fk_requests_approved',
            'requests',
            'approved_by',
            'users',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_requests_requested','requests');
        $this->dropForeignKey('fk_requests_approved','requests');
        $this->dropIndex('idx_requests_requested_by','requests');
        $this->dropIndex('idx_requests_approved_by','requests');
        
        $this->dropTable('requests');
    }
}
