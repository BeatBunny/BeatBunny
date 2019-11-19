<?php

namespace frontend\models;
use phpDocumentor\Reflection\Types\This;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $verification_token
 *
 * @property Profile[] $profiles
 */
class User extends \yii\db\ActiveRecord
{
    public $new_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['new_password'], 'string'],
            [['password_reset_token'], 'unique'],
            [['password_hash'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * @param $new_password
     * @return string
     * @throws \yii\base\Exception
     */


     public function updatePassword($new_password)
    {
        return $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($new_password);
    }

    public function decrypt()
    {
         return Yii::$app->getSecurity()->decryptByPassword($this->password_hash, $this->new_password);
    }
    public function validatePass(){
         return Yii::$app->getSecurity()->validatePassword($this->new_password,$this->password_hash);
    }

    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id_user' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

}
