<?php 
use yii\grid\GridView;

$this->title = Yii::$app->name . " Requests";
?>

<div>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'tableOptions' => ['class'=>'table table-striped table-hover'],
      'columns' => [
      	'id',
      	'date',
      	['label'=>'Requested by', 'attribute'=>'requestedBy.fullname'],
      	['label'=>'Department', 'attribute'=>'requestedBy.department'],
      	['label'=>'Approved by', 'attribute'=>'approvedBy.fullname'],
      	['label'=>'Status Code', 'attribute'=>'status'],
      	'statusText'
      ]
	]); ?>
</div>