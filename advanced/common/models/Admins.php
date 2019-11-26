<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admins}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 */
class Admins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admins}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdminsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminsQuery(get_called_class());
    }
}
