<?php 

namespace app\models;
use Yii;
use yii\base\Model;

class PurchaseOrderForm extends Model
{
	public $request_id;
	public $date;
	public $supplier;
	public $status;
	public $orderItemsPrice;

	public function rules()
	{
		return [
			[['request_id', 'date', 'supplier'], 'required'],
			[['request_id','status'], 'integer'],
			['orderItemsPrice', 'safe'],
			[['supplier'], 'string', 'max' => 255],
			[['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requests::className(), 'targetAttribute' => ['request_id' => 'id']],
		];
	}

	public function attributeLabels()
	{
		return [
			'request_id' => 'Request ID',
			'date' => 'Date',
			'supplier' => 'Supplier',
			'status' => 'Status',
			'orderItemsPrice' => 'Order Items'
		];
	}
}

?>