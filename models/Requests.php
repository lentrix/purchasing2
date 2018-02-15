<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requests".
 *
 * @property int $id
 * @property string $date
 * @property int $requested_by
 * @property int $approved_by
 * @property int $status
 *
 * @property PurchaseOrders[] $purchaseOrders
 * @property RequestItems[] $requestItems
 * @property Users $approvedBy
 * @property Users $requestedBy
 */
class Requests extends \yii\db\ActiveRecord
{
    public const STATUS_PENDING = 10;
    public const STATUS_DENIED = 13;
    public const STATUS_APPROVED = 15;
    public const STATUS_PROCESSING = 20;
    public const STATUS_ISSUED = 25;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['requested_by', 'approved_by', 'status'], 'integer'],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['approved_by' => 'id']],
            [['requested_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['requested_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'requested_by' => 'Requested By',
            'approved_by' => 'Approved By',
            'status' => 'Status',
            'statusText' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrders::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestItems()
    {
        return $this->hasMany(RequestItems::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'approved_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'requested_by']);
    }

    public function getDateString()
    {
        return date('F d, Y', strtotime($this->date));
    }

    public function getStatusText()
    {
        switch($this->status) {
            case static::STATUS_PENDING : return "Pending";
            case static::STATUS_DENIED : return "Denied";
            case static::STATUS_APPROVED : return "Approved";
            case static::STATUS_PROCESSING : return "Under Processing";
            case static::STATUS_ISSUED : return "Purchase Order Issued";
        }
    }

    public static function getApproved()
    {
        return static::find()->where(['status'=>static::STATUS_APPROVED])
            ->orderBy('date ASC')->limit(20)->all();
    }
}
