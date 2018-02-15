<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Change Password';

$this->params['breadcrumbs'][] = 'Change Password';

?>

<h1>Change Password</h1>

<div class="row">
    <div class="col-md-5">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($changePasswordForm, 'currentPassword')->passwordInput() ?>

            <?= $form->field($changePasswordForm, 'newPassword')->passwordInput() ?>

            <?= $form->field($changePasswordForm, 'repeatPassword')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Change Password', ['class'=>'btn btn-primary']); ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

