<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchaseOrderItems".
 *
 * @property int $id
 * @property int $purchaseOrder_id
 * @property int $requestItem_id
 * @property string $name
 * @property int $quantity
 * @property string $unit_price
 * @property string $unit_measurement
 *
 * @property PurchaseOrders $purchaseOrder
 * @property RequestItems $requestItem
 */
class PurchaseOrderItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchaseOrderItems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseOrder_id', 'requestItem_id', 'name'], 'required'],
            [['purchaseOrder_id', 'requestItem_id', 'quantity'], 'integer'],
            [['unit_price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['unit_measurement'], 'string', 'max' => 45],
            [['purchaseOrder_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrders::className(), 'targetAttribute' => ['purchaseOrder_id' => 'id']],
            [['requestItem_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestItems::className(), 'targetAttribute' => ['requestItem_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchaseOrder_id' => 'Purchase Order ID',
            'requestItem_id' => 'Request Item ID',
            'name' => 'Name',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'unit_measurement' => 'Unit Measurement',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrders::className(), ['id' => 'purchaseOrder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestItem()
    {
        return $this->hasOne(RequestItems::className(), ['id' => 'requestItem_id']);
    }
}
