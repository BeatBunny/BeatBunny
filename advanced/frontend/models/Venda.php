<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "venda".
 *
 * @property int $id
 * @property string $data
 * @property double $valorTotal
 * @property int $profile_id
 *
 * @property Linhavenda[] $linhavendas
 * @property Profile $profile
 */
class Venda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['valorTotal'], 'number'],
            [['profile_id'], 'required'],
            [['profile_id'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'valorTotal' => 'Valor Total',
            'profile_id' => 'Profile ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavenda::className(), ['venda_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return VendaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VendaQuery(get_called_class());
    }
}
