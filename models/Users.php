<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $authKey
 * @property int $role
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public const ROLE_ADMIN = 100;
    public const ROLE_PURCHASING_OFFICER = 200;
    public const ROLE_DEPARTMENT_HEAD = 300;
    public const ROLE_STAFF = 400;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash','department'], 'required'],
            [['role'], 'integer'],
            [['username', 'fullname', 'password_hash', 'authKey'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password',
            'authKey' => 'Auth Key',
            'role' => 'Role',
            'department' => 'Department',
            'roleString' => "Role",
            'fullname' => 'Full Name',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getRoleString() {
        switch($this->role) {
            case 100 : return "Administrator";
            case 200 : return "Purchasing Officer";
            case 300 : return "Department Head";
            case 400 : return "Staff";
        }
    }

    public function getApprovedRequests()
    {
        return Requests::find()->joinWith('approvedBy')
            ->where(['approved_by'=>$this->id, 'status'=>Requests::STATUS_APPROVED])
            ->orderBy('date DESC')->limit(20)->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnRequests()
    {
        return $this->hasMany(Requests::className(), ['requested_by' => 'id']);
    }

    public function getPendingRequests()
    {
        return Requests::find()
            ->joinWith('requestedBy')
            ->where([
                'approved_by'=>null,
                'users.department'=>$this->department
            ])->limit(20)->all();
    }

    public function getDeniedRequests()
    {
        return Requests::find()
            ->joinWith('requestedBy')
            ->where([
                'approved_by'=>$this->id,
                'status'=>Requests::STATUS_DENIED
            ])->limit(20)->all();
    }
}
