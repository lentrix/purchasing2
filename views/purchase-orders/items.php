<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->name . " | Purchase Order Items";
$this->params['breadcrumbs'][] =  [
	'label'=>'View Request', 
	'url'=>['/requests/view','id'=>$purchaseOrder->request->id]
];
$this->params['breadcrumbs'][] = 'Purchase Order Items';
?>

<h1>Purchase Order Items</h1>

<div class="row">
	<div class="col-md-4">
		<h3>Purchase Order Details</h3>
		<table class="table table-striped table-bordered">
			<tr><th>Request ID</th><td><?= $purchaseOrder->request_id?></td></tr>
			<tr><th>Date</th><td><?= $purchaseOrder->date?></td></tr>
			<tr><th>Supplier</th><td><?= $purchaseOrder->supplier?></td></tr>
			</tr>
		</table>
	</div>
	<div class="col-md-8">
		<h3>Items Details</h3>
		
		<?php $form=ActiveForm::begin() ?>
		<table class="table table-bordered">
			<tr>
				<th>Name</th>
				<th>Quantity</th>
				<th>Unit Measurement</th>
				<th>Unit Price</th>
				<th>TOTAL</th>
			</tr>
			<?php foreach($orderItems as $idx=>$poItem): ?>
				<tr>
					<td><?= $poItem->name;?></td>
					<td><?= $poItem->quantity;?></td>
					<td><?= $poItem->unit_measurement;?></td>
					<td><?= $form->field($poItem, "[$idx]unit_price")->textInput()->label('') ?></td>
					<td><span id="total_<?=$poItem->id?>"></span></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?= Html::submitButton('Finalize Purchase Order',['class'=>'btn btn-primary', 'name'=>'finalize']); ?>
		<?php ActiveForm::end() ?>
	</div>
</div>