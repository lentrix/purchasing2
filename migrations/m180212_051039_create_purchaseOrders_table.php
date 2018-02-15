<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purchaseOrders`.
 */
class m180212_051039_create_purchaseOrders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('purchaseOrders', [
            'id' => $this->primaryKey(),
            'request_id'=>$this->integer()->notNull(),
            'date'=>$this->date()->notNull(),
            'supplier'=>$this->string()->notNull(),
            'status'=>$this->smallInteger(1)->defaultValue(1)
        ]);

        $this->createIndex(
            'idx_purchaseOrders_request_id',
            'purchaseOrders',
            'request_id'
        );

        $this->addForeignKey(
            'fk_purchaseOrders_requests',
            'purchaseOrders',
            'request_id',
            'requests',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_purchaseOrders_requests','purchaseOrders');
        $this->dropIndex('idx_purchaseOrders_request_id','purchaseOrders');
        $this->dropTable('purchaseOrders');
    }
}
