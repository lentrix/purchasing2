<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name . " | Issue Purchase Order";
$this->params['breadcrumbs'][] = ['label'=>'View Request','url'=>['/requests/view', 'id'=>$request->id]];
$this->params['breadcrumbs'][] = 'Issue Purchase Order';
?>
<h1>Issue Purchase Order</h1>
<div class="row">
	<div class="col-md-4">
		<?php $form = ActiveForm::begin() ;?>

		<?= $form->field($po, 'request_id'); ?>
		<?= $form->field($po, 'date'); ?>
		<?= $form->field($po, 'supplier'); ?>

		<div class="form-group">
			<?= Html::submitButton('Save and Continue',['class'=>'btn btn-primary']); ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>