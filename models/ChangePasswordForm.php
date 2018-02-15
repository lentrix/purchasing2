<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePasswordForm extends Model
{
    public $repeatPassword;
    public $currentPassword;
    public $newPassword;

    public function attributeLabels() {
        return [
            'repeatPassword' => 'Repeat New Password',
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password'
        ];
    }

    public function rules() {
        return [
            [['repeatPassword','newPassword','currentPassword'], 'required'],
            [['repeatPassword','newPassword','currentPassword'], 'string'],
            [['repeatPassword', 'newPassword'], 'same'],
        ];
    }

    public function same($attribute_name, $params) {
        if($this->newPassword !== $this->repeatPassword) {
            $this->addError($attribute_name, 'The new passwords did not match!');
        }
    }
}