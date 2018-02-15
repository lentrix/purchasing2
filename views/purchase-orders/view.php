<?php
$this->title = Yii::$app->name . " | View Purchase Order";
$this->params['breadcrumbs'][] = ['label'=>'View Request', 'url'=>['/requests/view', 'id'=>$model->request->id]];
$this->params['breadcrumbs'][] = 'View Purchase Order';
?>
<h1>View Purchase Order</h1>
<div class="col">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong class="large-text">Purchase Order</strong>
			</div>
			<div class="panel-body">
				<span><strong>Supplier :</strong> <?= $model->supplier ?></span>
				<span class="pull-right"><strong>Date : </strong> <?= date('F d, Y', strtotime($model->date)) ?></span>
				<hr>
				<table class="table table-bordered">
					<tr>
						<th>Item Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total</th>
					</tr>
					<?php $total = 0; ?>
					<?php foreach($model->purchaseOrderItems as $oItem): ?>
						<tr>
							<td><?= $oItem->name ?></td>
							<td><?= $oItem->quantity ?> <?= $oItem->unit_measurement ?></td>
							<td align="right"><?= number_format($oItem->unit_price,2) ?></td>
							<td align="right"><?= number_format($subTotal = $oItem->quantity*$oItem->unit_price, 2) ?></td>
						</tr>
						<?php $total += $subTotal; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="3"><strong>T O T A L</strong></td>
						<td align="right"><strong><?= number_format($total, 2) ?></strong></td>
					</tr>
				</table>
				<span><strong>Requested by : </strong><?= $model->request->requestedBy->fullname ?></span>
				<span class="pull-right"><strong>Approved by : </strong><?= $model->request->approvedBy->fullname ?></span>
				<hr>
				<div class="large-text" style="text-align: center"><strong><?= $model->request->requestedBy->department ?></strong></div>
			</div>
		</div>
	</div>
</div>