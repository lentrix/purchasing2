<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use app\models\Users;
use app\models\Requests;

$user = Yii::$app->user->identity;

$this->title = Yii::$app->name . " | View Request";
$this->params['breadcrumbs'][] = 'View Request';
?>
<h2>
	View Request
	<?php if(
		Yii::$app->user->identity->role==Users::ROLE_PURCHASING_OFFICER &&
		$request->status==Requests::STATUS_APPROVED &&
		!$request->purchaseOrder): ?>
	<?= Html::a('Issue Purchase Order',[
				'purchase-orders/create','request_id'=>$request->id],
				[
					'class'=>'btn btn-lg btn-primary pull-right',
				]
			); ?>
	<?php endif; ?>

	<?php if($request->purchaseOrder): ?>
		<?= Html::a('View Purchase Order',[
				'purchase-orders/view','id'=>$request->purchaseOrder->id],
				[
					'class'=>'btn btn-lg btn-primary pull-right',
				]
			); ?>
	<?php endif; ?>
</h2>

<div class="row">
	<div class="col-md-4">
		<h3>Request Info</h3>
		<?= DetailView::widget([
			'model' => $request,
			'attributes' => [
				'id',
				'dateString',
				'statusText',
				['label'=>'by', 'attribute'=>'approvedBy.fullname']
			]
		]);?>
		<?php if(!$request->approved_by && $user->id===$request->requested_by): ?>
			<p>
			<?=Html::a('Cancel Request',
				['/requests/cancel','id'=>$request->id],
				[
					'class'=>'btn btn-warning',
					'data'=>[
						'confirm'=>'Are you sure to cancel this request?',
						'method'=>'post'
					]
				]); 
			?>
			<?=Html::a('Update Request',
				['/requests/populate-request', 'id'=>$request->id],
				['class'=>'btn btn-info']
			);?>
			</p>
		<?php endif; ?>
		<?php if($user->role==Users::ROLE_DEPARTMENT_HEAD 
			&& $request->status==Requests::STATUS_PENDING): ?>
			<p>
			<?= Html::a('Approve Request', 
				['/requests/approve','id'=>$request->id],
				[
					'class'=>'btn btn-success',
					'data'=> [
						'method'=>'post',
						'confirm'=>'You are about to approve this request!',
					],
				]
			);?>
			<?= Html::a('Deny Request', 
				['/requests/deny','id'=>$request->id],
				[
					'class'=>'btn btn-warning',
					'data'=>[
						'method'=>'post',
						'confirm'=>'Are you sure to deny this request?'
					]
				]
			);?>
			</p>
		<?php endif; ?>
	</div>
	<div class="col-md-8">
		<h3>Requested Items</h3>
		<table class="table table-striped">
			<thead>
				<tr><th>Name</th><th>Quantity</th><th>Unit</th></tr>
			</thead>
			<tbody>
				<?php foreach($request->requestItems as $item): ?>
					<tr>
						<td><?= $item->name;?></td>
						<td><?= $item->quantity;?></td>
						<td><?= $item->unit_measurement ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
