<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $new_password;
    public $old_password;
    public $repeat_password;
    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    public function rules()
    {
        return [
//            array('old_password', 'new_password', 'repeat_password', 'required', 'on' => 'changePwd'),
//            array('old_password', 'findPasswords', 'on' => 'changePwd'),
//            array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changePwd'),
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            [['password_hash'], 'string'],
        ];
    }

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
     * {@inheritdoc}
     */



    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $access = static::find()->where(['auth_key' => $token])->one();
        return isset($access) ? $access : null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function findPasswords($attribute, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->password != md5($this->old_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $username = $this->username;
        $password_hash = $this->password_hash;
        $password_reset_token =$this->password_reset_token;
        $email =$this->email;
        $status = $this->status;
        $created_at = $this->created_at;
        $updated_at =$this->updated_at;
        $verification_token= $this->verification_token;

        $myObj = new User();
        $myObj->id = $id;
        $myObj->username = $username;
        $myObj->password_hash =$password_hash;
        $myObj->password_reset_token = $password_reset_token;
        $myObj->email =$email;
        $myObj->status = $status;
        $myObj->created_at =$created_at;
        $myObj->updated_at = $updated_at;
        $myObj->verification_token =$verification_token;

        $myJSON = Json::encode($myObj);
        if ($insert) {
            $this->FazPublish("INSERT_Um_Utilizador_Criou_Uma_Conta", $myJSON);
        }
    }

    public function FazPublish($canal, $msg)
    {
        $server = '127.0.0.1';
        $port = 1883;
        $username = $this->username;
        $password = "";
        $client_id = uniqid();
        $mqtt= new phpMQTT($server, $port, $client_id);
        try {
            if ($mqtt->connect(true,null)) {
                $mqtt->publish($canal, $msg, 1);
                $mqtt->disconnect();
                $mqtt->close();

            } else {
                file_put_contents("debug.output", "Time out!");
            }
        }catch (\Exception $X)
        {}
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */

}
