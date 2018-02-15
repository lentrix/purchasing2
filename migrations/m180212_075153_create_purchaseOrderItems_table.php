<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purchaseOrderItems`.
 */
class m180212_075153_create_purchaseOrderItems_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('purchaseOrderItems', [
            'id' => $this->primaryKey(),
            'purchaseOrder_id' => $this->integer()->notNull(),
            'requestItem_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'quantity' => $this->integer(),
            'unit_price'=>$this->money(),
            'unit_measurement' => $this->string(45)->defaultValue('pieces')
        ]);

        $this->createIndex(
            'idx_purchaseOrderItems_purchaseOrder_id',
            'purchaseOrderItems',
            'purchaseOrder_id'
        );

        $this->addForeignKey(
            'fk_purchaseOrderItems_purchaseOrder',
            'purchaseOrderItems',
            'purchaseOrder_id',
            'purchaseOrders',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx_purchaseOrderItems_requestItem_id',
            'purchaseOrderItems',
            'requestItem_id'
        );

        $this->addForeignKey(
            'fk_purchaseOrderItems_requestItem',
            'purchaseOrderItems',
            'requestItem_id',
            'requestItems',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_purchaseOrderItems_purchaseOrder','purchaseOrderItems');
        $this->dropIndex('idx_purchaseOrderItems_purchaseOrder_id','purchaseOrderItems');
        $this->dropForeignKey('fk_purchaseOrderItems_requestItem','purchaseOrderItems');
        $this->dropIndex('idx_purchaseOrderItems_requestItem_id','purchaseOrderItems');
        $this->dropTable('purchaseOrderItems');
    }
}
