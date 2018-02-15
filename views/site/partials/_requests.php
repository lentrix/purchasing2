<?php 
use yii\helpers\Html;

?>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong class="large-text"><?=$title?></strong>
  </div>
  <div class="panel-body">
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Date</th><th>Requested by</th><th>Status</th><th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($requests as $request): ?>
        <tr>
          <td><?= date('F d, Y', strtotime($request->date)) ?></td>
          <td><?= $request->requestedBy->fullname ?></td>
          <td><?= $request->statusText ?></td>
          <td align="right">
            <?= Html::a('<i class="glyphicon glyphicon-open"></i>',
              ['/requests/view','id'=>$request->id],
              ['class'=>'btn btn-info btn-xs']
            ); ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>