<?php
use yii\helpers\Html;

$this->title = Yii::$app->name . " | Staff Home";
?>
<div class="row">
  <div class="col-md-6">
    <?= $this->render('partials/_requests',[
    	'requests'=>Yii::$app->user->identity->ownRequests,
    	'title' => 'My Requests'
    	]);?>
  </div>
</div>