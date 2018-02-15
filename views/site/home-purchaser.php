<?php
use yii\helpers\Html;
use app\models\Requests;

$this->title = Yii::$app->name . " | Purchaser Home";
?>
<div class="row">
  <div class="col-md-6">
    <?= $this->render('partials/_requests',[
    	'requests'=>Yii::$app->user->identity->ownRequests,
    	'title' => 'My Requests'
    	]);?>
  </div>
  <div class="col-md-6">
    <?= $this->render('partials/_requests',[
    	'requests'=>Requests::getApproved(),
    	'title' => 'Approved Requests'
    	]);?>
  </div>
</div>