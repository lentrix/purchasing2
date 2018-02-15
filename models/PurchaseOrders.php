<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchaseOrders".
 *
 * @property int $id
 * @property int $request_id
 * @property string $date
 * @property string $supplier
 * @property int $status
 *
 * @property PurchaseOrderItems[] $purchaseOrderItems
 * @property Requests $request
 */
class PurchaseOrders extends \yii\db\ActiveRecord
{
    const STATUS_ISSUED = 10;
    const STATUS_TRANSIT = 15;
    const STATUS_RECEIVED = 20;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchaseOrders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'date', 'supplier'], 'required'],
            [['request_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['supplier'], 'string', 'max' => 255],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requests::className(), 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'date' => 'Date',
            'supplier' => 'Supplier',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItems::className(), ['purchaseOrder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Requests::className(), ['id' => 'request_id']);
    }

    public function getStatusText()
    {
        switch($this->status) {
            case static::STATUS_ISSUED: return "Purchase Order Issued";
            case static::STATUS_TRANSIT: return "Order in transit";
            case static::STATUS_RECEIVED: return "Order received";
        }
    }
}
