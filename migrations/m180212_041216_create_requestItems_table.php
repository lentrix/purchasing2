<?php

use yii\db\Migration;

/**
 * Handles the creation of table `requestItems`.
 */
class m180212_041216_create_requestItems_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('requestItems', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'quantity' => $this->integer()->defaultValue(1),
            'unit_measurement' => $this->string(45)->defaultValue('pieces'),
        ]);

        $this->createIndex(
            'idx_requestItems_request_id',
            'requestItems',
            'request_id'
        );

        $this->addForeignKey(
            'fk_requestItems_requests',
            'requestItems',
            'request_id',
            'requests',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_requestItems_requests','requestItems');
        $this->dropIndex('idx_requestItems_request_id','requestItems');
        $this->dropTable('requestItems');
    }
}
