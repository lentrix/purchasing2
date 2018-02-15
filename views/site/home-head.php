<?php 
$this->title = Yii::$app->name . " | Department Head Home";

?>

<div class="row">
	<div class="col-md-6">
		
		<?= $this->render('partials/_requests',[
			'requests'=>Yii::$app->user->identity->ownRequests,
			'title' => 'My Requests'
			]); ?>

		<?= $this->render('partials/_requests',[
			'requests'=>Yii::$app->user->identity->approvedRequests,
			'title' => 'Requests I Approved'
			]); ?>		

	</div>
	<div class="col-md-6">
		<?= $this->render('partials/_requests',[
			'requests'=>Yii::$app->user->identity->pendingRequests,
			'title' => 'Pending Requests'
			]); ?>

		<?= $this->render('partials/_requests',[
			'requests'=>Yii::$app->user->identity->deniedRequests,
			'title'=>'Requests I Denied'
			]); ?>
	</div>
</div>