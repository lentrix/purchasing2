<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name . " | Make Request";
$this->params['breadcrumbs'][] = 'Make Request';
?>
<h2>Make Request</h2>
<div class="row">
	<div class="col-md-3">
		<h3>Item Form</h3>
		<?php $form = ActiveForm::begin(); ?>
			<?= $form->field($requestItem, 'name')->textInput(); ?>
			<?= $form->field($requestItem, 'quantity')->textInput(['type'=>'number']); ?>
			<?= $form->field($requestItem, 'unit_measurement')->dropDownList(
				\app\components\UnitMeasurement::MEASUREMENTS
				); ?>
			<div class="form-group">
				<?= Html::submitButton('Add Item',['class'=>'btn btn-default']);?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="col-md-9">
		<h3>Items</h3>
		<table class="table table-striped">
			<thead>
				<tr><th>Name</th><th>Qty</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
			<?php foreach($request->requestItems as $item): ?>
				<tr>
					<td><?= $item->name ?></td>
					<td><?= $item->quantity ?> <?= $item->unit_measurement ?></td>
					<td align="right">
						<?= Html::a('<i class="glyphicon glyphicon-remove"></i>',
						['/requests/remove-item','item_id'=>$item->id],
						[
							'class'=>'btn btn-danger btn-xs',
							'data' => [
								'confirm' => 'Are you sure to remove this item?',
								'method' => 'post'
							]
						]);?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?= Html::a('Finish Request', 
			['/requests/finish-request','id'=>$request->id],
			['class'=>'btn btn-success btn-lg pull-right']
		); ?>
	</div>
</div>